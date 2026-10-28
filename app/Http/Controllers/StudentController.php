<?php
namespace App\Http\Controllers; use App\Models\{PracticumClass,PracticumRegistration,RequirementSubmission,User}; use Illuminate\Http\Request; use Illuminate\Support\Facades\DB;
class StudentController extends Controller {
 public function dashboard(Request $r){ $registrations=PracticumRegistration::with(['preferredClass.course','preferredClass.laboratory','finalClass.course','finalClass.laboratory','submissions.requirement'])->where('student_id',$r->user()->id)->latest()->get(); return view('mahasiswa.dashboard',compact('registrations')); }
 public function practicums(Request $r){
  $classes=PracticumClass::with(['course.requirements','laboratory','lecturer'])
   ->withCount([
    'registrations as pending_registrations_count'=>fn($q)=>$q->where('status','pending_verification'),
    'finalRegistrations as approved_registrations_count'=>fn($q)=>$q->where('status','approved'),
   ])
   ->where('is_active',true)
   ->whereNotExists(function($query) use($r){
    $query->selectRaw('1')
     ->from('practicum_registrations as selected_registrations')
     ->join('practicum_classes as selected_classes','selected_classes.id','=','selected_registrations.practicum_class_id')
     ->where('selected_registrations.student_id',$r->user()->id)
     ->whereColumn('selected_classes.course_id','practicum_classes.course_id')
     ->whereColumn('selected_classes.academic_year','practicum_classes.academic_year')
     ->whereColumn('selected_classes.semester','practicum_classes.semester');
   })
   ->where(fn($q)=>$q->whereNull('enrollment_starts_at')->orWhere('enrollment_starts_at','<=',now()))
   ->where(fn($q)=>$q->whereNull('enrollment_deadline')->orWhere('enrollment_deadline','>=',now()))
   ->orderBy('practicum_date')->orderBy('start_time')->get();
  return view('mahasiswa.practicums',compact('classes'));
 }
 public function practicumCertificate(Request $r, PracticumRegistration $registration){ abort_unless((int) $registration->student_id===(int) $r->user()->id && $registration->passed(),403); $registration->load(['student','finalClass.course','finalClass.laboratory']); $head=User::where('role','kepala_labor')->where('laboratory_id',$registration->finalClass->laboratory_id)->first(); return view('mahasiswa.practicum-certificate',compact('registration','head')); }
 public function apply(PracticumClass $class){
  abort_unless($class->registrationIsOpen(),403,'Pendaftaran praktikum belum dibuka atau batas pengisian telah lewat.');
  $alreadySelected=PracticumRegistration::where('student_id',auth()->id())
   ->whereHas('preferredClass',fn($q)=>$q->where('course_id',$class->course_id)
    ->where('academic_year',$class->academic_year)->where('semester',$class->semester))
   ->exists();
  abort_unless(!$alreadySelected,403,'Anda sudah memilih jadwal untuk praktikum ini pada semester tersebut. Hubungi laboran atau admin jika ingin mengubah jadwal.');
  $occupied=$class->registrations()->where('status','pending_verification')->count()
   +$class->finalRegistrations()->where('status','approved')->count();
  abort_unless($occupied < $class->capacity,403,'Kapasitas kelas ini sudah penuh. Silakan pilih jadwal praktikum lain.');
  $class->load(['course.requirements','laboratory','lecturer']);
  return view('mahasiswa.apply',compact('class'));
 }
 public function store(Request $r,PracticumClass $class){
  abort_unless($class->registrationIsOpen(),403,'Pendaftaran praktikum belum dibuka atau batas pengisian telah lewat.');
  $r->validate(['confirm_schedule_final'=>'accepted']);
  $requirements=$class->course->requirements()->where('is_required',true)->get();
  foreach($requirements as $req){ $r->validate(['req_'.$req->id=>'required|file|mimes:pdf,jpg,jpeg,png|max:2048']); }
  DB::transaction(function() use($r,$class,$requirements){
   User::whereKey($r->user()->id)->lockForUpdate()->firstOrFail();
   $alreadySelected=PracticumRegistration::where('student_id',$r->user()->id)
    ->whereHas('preferredClass',fn($q)=>$q->where('course_id',$class->course_id)
     ->where('academic_year',$class->academic_year)->where('semester',$class->semester))
    ->exists();
   if($alreadySelected){
    throw \Illuminate\Validation\ValidationException::withMessages([
     'schedule'=>'Anda sudah memilih jadwal untuk praktikum ini pada semester tersebut. Hubungi laboran atau admin jika ingin mengubah jadwal.',
    ]);
   }
   $lockedClass=PracticumClass::whereKey($class->id)->lockForUpdate()->firstOrFail();
   $occupied=$lockedClass->registrations()->where('status','pending_verification')->count()
    +$lockedClass->finalRegistrations()->where('status','approved')->count();
   if($occupied >= $lockedClass->capacity){
    throw \Illuminate\Validation\ValidationException::withMessages([
     'schedule'=>'Kapasitas kelas ini sudah penuh. Silakan pilih jadwal praktikum lain.',
    ]);
   }
   $reg=PracticumRegistration::create(['student_id'=>$r->user()->id,'practicum_class_id'=>$lockedClass->id,'status'=>'pending_verification']);
   foreach($requirements as $req){
    $path=$r->file('req_'.$req->id)->store('praktikum-syarat','public');
    RequirementSubmission::create(['registration_id'=>$reg->id,'requirement_id'=>$req->id,'file_path'=>$path]);
   }
  });
  return redirect()->route('mahasiswa.dashboard')->with('success','Pilihan jadwal terkunci dan pendaftaran dikirim. Hubungi laboran atau admin jika ingin mengubah jadwal.');
 }
}
