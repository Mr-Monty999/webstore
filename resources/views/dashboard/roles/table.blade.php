   <div class="col-12">
       <div class="card my-4">
           <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
               <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                   <h6 class="text-white text-capitalize ps-3 text-center">جدول الرتب</h6>
               </div>
           </div>
           <div class="card-body px-0 pb-2">
               <div class="table-responsive p-0">
                   <table class="table align-items-center mb-0">
                       <thead>
                           <tr>
                               <th class="text-uppercase text-primary font-weight-bolder">
                                   الرقم</th>
                               <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                   إسم الرتبة</th>

                               <th class="text-uppercase text-primary  font-weight-bolder">الاحداث</th>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $i = 0;
                           @endphp
                           @foreach ($roles as $role)
                               @if ($role->name != 'owner')
                                   <tr>
                                       <td>
                                           <p class="text-dark text-center">{{ ++$i }}</p>
                                       </td>
                                       <td>
                                           <p class="text-dark text-center">{{ $role->name }}</p>
                                       </td>

                                       <td class="align-middle text-center">
                                           <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-dark">تعديل
                                           </a>
                                           <form id="role-delete" method="post">
                                               @csrf
                                               @method('DELETE')
                                               <input type="text" name="id" hidden value="{{ $role->id }}">
                                               <button type="submit" class="btn btn-danger">حذف </button>
                                           </form>
                                       </td>
                                   </tr>
                               @endif
                           @endforeach


                       </tbody>
                   </table>

               </div>
           </div>
       </div>
   </div>
   {!! $roles->links() !!}
