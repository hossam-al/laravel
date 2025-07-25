         <div id="vodafone_form" class="payment-form" style="display: none;">

                        <form method="POST" action="{{ route('paymob.process') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="tel" class="form-label">phone</label>
                                <input maxlength="20" type="tel" class="form-control" id="tel" name="phone"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                required>
                            </div>


                            <button type="submit" class="btn btn-success w-100">Submit</button>
                        </form>

                </div>
