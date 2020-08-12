 <form class="forms-sample" action="{{route('updatetwilio')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}      
                           @if($twilio)
                            <div class="form-group">
                                <label for="msg_key">Twilio SID</label>
                                <input type="text" id="sid" class="form-control" value="{{$twilio->twilio_sid}}" name="sid">
                            </div>

                            <div class="form-group">
                                <label for="sender_id">Twilio Token</label>
                                <input type="text" id="token" class="form-control" value="{{$twilio->twilio_token}}" name="token">
                            </div>
                             <div class="form-group">
                                <label for="sender_id">Twilio Phone</label>
                                <input type="text" id="phone" class="form-control" value="{{$twilio->twilio_phone}}" name="phone">
                            </div>
                            @else
                             <div class="form-group">
                                <label for="msg_key">Twilio SID</label>
                                <input type="text" id="sid" class="form-control" placeholder="Twilio SID" name="sid">
                            </div>

                            <div class="form-group">
                                <label for="sender_id">Twilio Token</label>
                                <input type="text" id="token" class="form-control" placeholder="Twilio Token" name="token">
                            </div>
                             <div class="form-group">
                                <label for="sender_id">Twilio Phone</label>
                                <input type="text" id="phone" class="form-control" placeholder="Twilio Phone" name="phone">
                            </div>
                            @endif

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" @click="updateRecord">
                                    <i class="la la-check-square-o"></i> Save
                                </button>
                            </div>
                            </form>