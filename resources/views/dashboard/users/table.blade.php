  <div class="col-12">
      <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3 text-center">جدول المشرفين</h6>
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
                                  اسم المشرف</th>
                              <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                  صورة المشرف</th>
                              <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                  تاريخ الانشاء</th>
                              <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                  الرتب</th>
                              <th class="text-uppercase text-primary  font-weight-bolder">الاحداث</th>
                          </tr>
                      </thead>
                      <tbody>
                          @php
                              use Illuminate\Support\Facades\Auth;
                              
                              $i = 0;
                          @endphp
                          @foreach ($users as $user)
                              @if ($user->id != Auth::id())
                                  <tr>
                                      <td>
                                          <p class="text-dark text-center">{{ ++$i }}</p>
                                      </td>
                                      <td>
                                          <p class="text-dark text-center">{{ $user->name }}</p>
                                      </td>
                                      <td>
                                          @if ($user->photo != null)
                                              <img src="{{ asset("storage/$user->photo") }}" alt="">
                                          @else
                                              <p class="text-dark text-center">لاتوجد صورة</p>
                                          @endif
                                      </td>
                                      <td>
                                          <p class="text-dark text-center" dir="ltr">
                                              {{ $user->created_at->diffForHumans() }}
                                          </p>
                                      </td>
                                      <td>
                                          <p class="text-dark text-center" dir="ltr">
                                              @foreach ($user->roles as $role)
                                                  {{ $role->name }},
                                              @endforeach
                                          </p>
                                      </td>

                                      <td class="align-middle text-center">
                                          <a href="{{ route('users.edit', $user->id) }}" class="btn btn-dark">تعديل
                                          </a>
                                          <form id="user-delete" method="post">
                                              @csrf
                                              @method('DELETE')
                                              <input type="text" id="user-id" hidden name="id"
                                                  value="{{ $user->id }}">
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
  {!! $users->links() !!}
