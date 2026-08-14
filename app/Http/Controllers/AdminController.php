<?php
namespace App\Http\Controllers;
use App\Models\{Course,LetterType,LetterRequirement,LetterWorkflowStep,Laboratory,PracticumClass,PracticumRegistration,TestingCategory,TestingRequest,TestingService,User}; use Illuminate\Http\Request; use Illuminate\Support\Facades\DB; use Illuminate\Support\Str;
class AdminController extends Controller {
 public function users(){ $users=User::with('laboratory')->orderBy('role')->orderBy('name')->get(); return view('admin.users',compact('users')); }
 public function createUser(){ $laboratories=Laboratory::orderBy('name')->get(); return view('admin.user-form',compact('laboratories')); }
 public function storeUser(Request $r){
  $data=$r->validate([
   'name'=>'required|string|max:255',
   'email'=>'required|email|max:255|unique:users,email',
   'npm'=>'nullable|string|max:50|unique:users,npm',
   'phone'=>'nullable|string|max:30',
   'address'=>'nullable|string|max:1000',
   'role'=>'required|in:admin,mahasiswa,dosen,tenaga_labor,kepala_labor,prodi,umum',
   'laboratory_id'=>'nullable|exists:laboratories,id',
   'password'=>'required|string|min:6|confirmed',
  ]);
  if($data['role']==='mahasiswa' && empty($data['npm'])) return back()->withErrors(['npm'=>'NPM wajib diisi untuk akun mahasiswa.'])->withInput();
  if(in_array($data['role'],['tenaga_labor','kepala_labor'],true) && empty($data['laboratory_id'])) return back()->withErrors(['laboratory_id'=>'Laboratorium wajib dipilih untuk Tenaga Labor/Kepala Labor.'])->withInput();
  if(!in_array($data['role'],['tenaga_labor','kepala_labor'],true)) $data['laboratory_id']=null;
  if($data['role']!=='mahasiswa') $data['npm']=null;
  User::create($data);
  return redirect()->route('admin.users')->with('success','Akun baru berhasil dibuat oleh Admin.');
 }
 public function dashboard(){ $testByCategory=TestingRequest::join('testing_services','testing_requests.testing_service_id','=','testing_services.id')->join('testing_categories','testing_services.testing_category_id','=','testing_categories.id')->select('testing_categories.name',DB::raw('COUNT(*) total'))->groupBy('testing_categories.name')->orderByDesc('total')->get(); $classChoices=PracticumClass::with('course')->withCount('registrations')->get(); return view('admin.dashboard',['studentCount'=>User::where('role','mahasiswa')->count(),'activeClasses'=>PracticumClass::where('is_active',true)->count(),'pendingRegistrations'=>PracticumRegistration::where('status','pending_verification')->count(),'activeTests'=>TestingRequest::whereIn('status',['pending_sample','sample_received','testing'])->count(),'testByCategory'=>$testByCategory,'classChoices'=>$classChoices]); }
 public function classes(){ $classes=PracticumClass::with(['course','laboratory','lecturer'])->withCount(['registrations','finalRegistrations'])->orderBy('day')->get(); return view('admin.classes',compact('classes')); }
 public function createClass(){ return view('admin.class-form',['class'=>new PracticumClass,'courses'=>Course::all(),'laboratories'=>Laboratory::all(),'lecturers'=>User::where('role','dosen')->get()]); }
 public function storeClass(Request $r){ PracticumClass::create($this->classData($r)); return redirect()->route('admin.classes')->with('success','Jadwal/kelas praktikum berhasil ditambahkan.'); }
 public function editClass(PracticumClass $class){ return view('admin.class-form',compact('class')+['courses'=>Course::all(),'laboratories'=>Laboratory::all(),'lecturers'=>User::where('role','dosen')->get()]); }
 public function updateClass(Request $r,PracticumClass $class){ $class->update($this->classData($r)); return redirect()->route('admin.classes')->with('success','Jadwal/kelas berhasil diperbarui.'); }
 private function classData(Request $r): array { return $r->validate(['course_id'=>'required|exists:courses,id','laboratory_id'=>'required|exists:laboratories,id','lecturer_id'=>'nullable|exists:users,id','class_name'=>'required|string|max:20','room'=>'required|string|max:100','day'=>'required|string|max:20','start_time'=>'required','end_time'=>'required|after:start_time','capacity'=>'required|integer|min:1|max:300','semester'=>'required|string|max:20','academic_year'=>'required|string|max:20']); }
 public function registrations(){ $registrations=PracticumRegistration::with(['student','preferredClass.course','preferredClass.laboratory','finalClass','submissions.requirement'])->latest()->get(); $classes=PracticumClass::with('course')->where('is_active',true)->get(); return view('admin.registrations',compact('registrations','classes')); }
 public function verifyRegistration(Request $r,PracticumRegistration $registration){ $data=$r->validate(['decision'=>'required|in:approved,rejected','final_class_id'=>'nullable|required_if:decision,approved|exists:practicum_classes,id','admin_note'=>'nullable|string|max:1000']); if($data['decision']==='approved'){ $target=PracticumClass::findOrFail($data['final_class_id']); $filled=$target->finalRegistrations()->where('status','approved')->where('id','!=',$registration->id)->count(); if($filled >= $target->capacity) return back()->with('error','Kelas tujuan sudah penuh. Pilih kelas lain.'); }
  DB::transaction(function() use($registration,$data,$r){ $registration->update(['status'=>$data['decision'],'final_class_id'=>$data['decision']==='approved'?$data['final_class_id']:null,'admin_note'=>$data['admin_note']??null,'verified_by'=>$r->user()->id,'verified_at'=>now()]); $registration->submissions()->update(['status'=>$data['decision']==='approved'?'approved':'rejected','verified_by'=>$r->user()->id,'verified_at'=>now(),'note'=>$data['admin_note']??null]); }); return back()->with('success','Verifikasi pendaftaran praktikum diperbarui.'); }
 public function letterTypes(){ $types=LetterType::with(['requirements','workflowSteps'])->latest()->get(); return view('admin.letter-types',compact('types')); }
 public function createLetterType(){ return view('admin.letter-type-form'); }
 public function storeLetterType(Request $r){ $data=$r->validate(['code'=>'required|string|max:30|unique:letter_types,code','title'=>'required|string|max:255','description'=>'nullable|string','requirements'=>'nullable|array','requirements.*'=>'nullable|string|max:255','workflow_roles'=>'required|array|min:1','workflow_roles.*'=>'required|in:admin,mahasiswa,dosen,tenaga_labor,kepala_labor,prodi,umum','workflow_labels'=>'required|array|min:1','workflow_labels.*'=>'required|string|max:255']); DB::transaction(function() use($data,$r){ $type=LetterType::create(['code'=>strtoupper($data['code']),'title'=>$data['title'],'description'=>$data['description']??null,'created_by'=>$r->user()->id]); foreach(array_filter($data['requirements']??[]) as $req) LetterRequirement::create(['letter_type_id'=>$type->id,'title'=>$req,'is_required'=>true]); foreach($data['workflow_roles'] as $i=>$role) LetterWorkflowStep::create(['letter_type_id'=>$type->id,'step_order'=>$i+1,'role'=>$role,'label'=>$data['workflow_labels'][$i]??ucwords(str_replace('_',' ',$role))]); }); return redirect()->route('admin.letter-types')->with('success','Jenis surat dan alur berjenjang berhasil dibuat.'); }
 public function services(){ $categories=TestingCategory::with(['services.laboratory'])->get(); $laboratories=Laboratory::all(); return view('admin.services',compact('categories','laboratories')); }
 public function storeCategory(Request $r){ $d=$r->validate(['name'=>'required|string|max:100','description'=>'nullable|string']); TestingCategory::create(['name'=>$d['name'],'slug'=>Str::slug($d['name']).'-'.Str::lower(Str::random(4)),'description'=>$d['description']??null]); return back()->with('success','Kategori pengujian ditambahkan.'); }
 public function storeService(Request $r){ $d=$r->validate(['testing_category_id'=>'required|exists:testing_categories,id','laboratory_id'=>'required|exists:laboratories,id','code'=>'required|string|max:30|unique:testing_services,code','name'=>'required|string|max:150','description'=>'nullable|string','requirements'=>'nullable|string']); TestingService::create($d); return back()->with('success','Jenis pengujian berhasil ditambahkan.'); }
}
