   <div class="col-12">
       <div class="card my-4">
           <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
               <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                   <h6 class="text-white text-capitalize ps-3 text-center">جدول الاصناف</h6>
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
                                   اسم الصنف</th>

                               <th class="text-uppercase text-primary  font-weight-bolder">الاحداث</th>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $i = 0;
                           @endphp
                           @foreach ($items as $item)
                               <tr>
                                   <td>
                                       <p class="text-dark text-center">{{ ++$i }}</p>
                                   </td>
                                   <td>
                                       <p class="text-dark text-center">{{ $item->name }}</p>
                                   </td>

                                   <td class="align-middle text-center">
                                       @can('edit-items')
                                           <a href="{{ route('items.edit', $item->id) }}" class="btn btn-dark">تعديل
                                           </a>
                                       @endcan
                                       @can('delete-items')
                                           <form id="item-delete" method="post">
                                               @csrf
                                               @method('DELETE')
                                               <input type="text" name="id" hidden value="{{ $item->id }}">
                                               <button type="submit" class="btn btn-danger">حذف </button>
                                           </form>
                                       @endcan
                                   </td>
                               </tr>
                           @endforeach


                       </tbody>
                   </table>

               </div>
           </div>
       </div>
   </div>
   {!! $items->links() !!}
