    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3 text-center">جدول رسائل الزوار</h6>
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
                                    اسم الزائر</th>

                                <th class="text-uppercase text-primary  font-weight-bolder">الرسالة</th>
                                <th class="text-uppercase text-primary  font-weight-bolder">تاريخ الارسال</th>
                                <th class="text-uppercase text-primary  font-weight-bolder">الاحداث</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($feedbacks as $feedback)
                                <tr>
                                    <td>
                                        <p class="text-dark text-center">{{ ++$i }}</p>
                                    </td>
                                    <td>
                                        <p class="text-dark text-center">{{ $feedback->name }}</p>
                                    </td>
                                    <td>
                                        <p style="height:30px;width:150px;"
                                            class="text-dark text-center overflow-hidden">
                                            {{ $feedback->message }}
                                        </p>
                                        <a href="{{ route('dashboard.feedbacks.show', $feedback->id) }}"
                                            class="text-primary">قراءة المزيد</a>

                                    </td>
                                    <td>
                                        <p class="text-dark text-center">
                                            {{ $feedback->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('dashboard.feedbacks.show', $feedback->id) }}"
                                            class="btn btn-dark">عرض
                                        </a>
                                        <form id="feedback-delete" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="text" hidden name="id" value="{{ $feedback->id }}">
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
    {!! $feedbacks->links() !!}
