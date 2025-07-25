         <div id="visa_form" class="payment-form" style="display: none;">

                        <form method="POST" action="{{ route('paymob.process') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="card_name" class="form-label">اسم صاحب البطاقة</label>
                                <input maxlength="20" type="text" class="form-control" id="card_name" name="card_name"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="card_number" class="form-label">رقم البطاقة</label>
                                <input type="text" class="form-control" id="card_number" name="card_number"
                                    maxlength="16" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiry_date" class="form-label">تاريخ الانتهاء</label>
                                    <input type="text" id="expiry_date" name="expiry_date" maxlength="5"
                                        class="form-control" placeholder="MM/YY">

                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3"
                                        required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Submit</button>
                        </form>

                </div>
