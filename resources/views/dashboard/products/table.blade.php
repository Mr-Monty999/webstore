      <div class="col-12">
          <div class="card my-4">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                  <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                      <h6 class="text-white text-capitalize ps-3 text-center">جدول المنتجات</h6>
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
                                      اسم المنتج</th>
                                  <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                      سعر المنتج</th>
                                  <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                      التخفيض</th>
                                  <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                      صنف المنتج</th>
                                  <th class="text-uppercase text-primary  font-weight-bolder  ps-2">
                                      صورة المنتج</th>
                                  <th class="text-uppercase text-primary  font-weight-bolder">الاحداث</th>
                              </tr>
                          </thead>
                          <tbody>
                              @php
                                  $i = 0;
                              @endphp
                              @foreach ($products as $product)
                                  <tr>
                                      <td>
                                          <p class="text-dark text-center">{{ ++$i }}</p>
                                      </td>
                                      <td>
                                          <p class="text-dark text-center">{{ $product->name }}</p>
                                      </td>
                                      <td>
                                          <p class="text-dark text-center">
                                              {{ number_format($product->price) }}</p>
                                      </td>
                                      <td>
                                          @if ($product->discount != null)
                                              <p class="text-dark text-center">{{ $product->discount }}%
                                              </p>
                                          @else
                                              <p class="text-dark text-center">لايوجد تخفيض</p>
                                          @endif
                                      </td>
                                      <td>
                                          <p class="text-dark text-center">{{ $product->item->name }}</p>
                                      </td>

                                      <td>
                                          @if ($product->photo != null)
                                              <img src="{{ asset("storage/$product->photo") }}" alt="">
                                          @else
                                              <p class="text-dark text-center">لاتوجد صورة</p>
                                          @endif
                                      </td>
                                      <td class="align-middle text-center">
                                          <a href="{{ route('products.edit', $product->id) }}"
                                              class="btn btn-dark">تعديل </a>
                                          <form id="product-delete" method="post">
                                              @csrf
                                              @method('DELETE')
                                              <input type="text" name="id" id="product-id" hidden
                                                  value="{{ $product->id }}">
                                              <button type="submit" class="btn btn-danger">حذف </button>
                                          </form>
                                      </td>
                                  </tr>
                              @endforeach


                          </tbody>
                      </table>

                  </div>
              </div>
          </div>
      </div>
      {!! $products->links() !!}
