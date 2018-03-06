 <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Personal Information</a> </li>
                      <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Contact Information</a> </li>
                      <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Address</a> </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab"> 
                        
                        <!-- Start Personal Information -->
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Personal Information <!--<small>sub title</small>--></h2>
                            <ul class="nav navbar-right panel_toolbox">
                              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                  <li><a href="#">Settings 1</a> </li>
                                  <li><a href="#">Settings 2</a> </li>
                                </ul>
                              </li>
                              <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                            </ul>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content"> <br />
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="Title" required class="form-control col-md-7 col-xs-12" placeholder="Title">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <div id="gender" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="male">
                                      &nbsp; Male &nbsp; </label>
                                    <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="female" checked="">
                                      Female </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="birthday" class="date-picker form-control col-md-7 col-xs-12" required type="text" placeholder="Date Of Birth">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Height<span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="Height" name="Height" required class="form-control col-md-7 col-xs-12" placeholder="Height">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Weight<span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="Weight" name="Weight" required class="form-control col-md-7 col-xs-12" placeholder="Weight">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Ethnic Group</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="EthnicGroup" class="form-control col-md-7 col-xs-12" type="text" name="EthnicGroup" placeholder="Ethnic Group">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Citizenship</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="Citizenship" class="form-control col-md-7 col-xs-12" type="text" name="Citizenship" placeholder="Citizenship">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Marital Status</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <div id="gender" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="male">
                                      &nbsp; Yes &nbsp; </label>
                                    <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="female" checked="">
                                      No </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Religion</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="Religion" class="form-control col-md-7 col-xs-12" type="text" name="Citizenship" placeholder="Religion">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Blood Type</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <select class="form-control">
                                    <option>O +</option>
                                    <option>O -</option>
                                    <option>A +</option>
                                    <option>A -</option>
                                    <option>B +</option>
                                    <option>B -</option>
                                    <option>AB +</option>
                                    <option>AB -</option>
                                  </select>
                                </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <button type="submit" class="btn btn-primary">Cancel</button>
                                  <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>
                            </form>
                          </div>
                          <script type="text/javascript">
                        $(document).ready(function () {
                            $('#birthday').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4"
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        });
                    </script> 
                        </div>
                        <!-- End Personal Information --> 
                        
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab"> 
                        
                        <!-- Start Personal Information -->
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Personal Information <!--<small>sub title</small>--></h2>
                            <ul class="nav navbar-right panel_toolbox">
                              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                  <li><a href="#">Settings 1</a> </li>
                                  <li><a href="#">Settings 2</a> </li>
                                </ul>
                              </li>
                              <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                            </ul>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content"> <br />
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="Title" required class="form-control col-md-7 col-xs-12" placeholder="Title">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <div id="gender" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="male">
                                      &nbsp; Male &nbsp; </label>
                                    <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="female" checked="">
                                      Female </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="birthday" class="date-picker form-control col-md-7 col-xs-12" required type="text" placeholder="Date Of Birth">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Height<span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="Height" name="Height" required class="form-control col-md-7 col-xs-12" placeholder="Height">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Weight<span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="Weight" name="Weight" required class="form-control col-md-7 col-xs-12" placeholder="Weight">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Ethnic Group</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="EthnicGroup" class="form-control col-md-7 col-xs-12" type="text" name="EthnicGroup" placeholder="Ethnic Group">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Citizenship</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="Citizenship" class="form-control col-md-7 col-xs-12" type="text" name="Citizenship" placeholder="Citizenship">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Marital Status</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <div id="gender" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="male">
                                      &nbsp; Yes &nbsp; </label>
                                    <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="female" checked="">
                                      No </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Religion</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="Religion" class="form-control col-md-7 col-xs-12" type="text" name="Citizenship" placeholder="Religion">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Blood Type</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="BloodType" class="form-control col-md-7 col-xs-12" type="text" name="BloodType" placeholder="Blood Type">
                                </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <button type="submit" class="btn btn-primary">Cancel</button>
                                  <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>
                            </form>
                          </div>
                          <script type="text/javascript">
                        $(document).ready(function () {
                            $('#birthday').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4"
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        });
                    </script> 
                        </div>
                        <!-- End Personal Information --> 
                        
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab"> 
                        <!-- Start Personal Information -->
                        <div class="x_panel">
                          <div class="x_title">
                            <h2>Personal Information <!--<small>sub title</small>--></h2>
                            <ul class="nav navbar-right panel_toolbox">
                              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                  <li><a href="#">Settings 1</a> </li>
                                  <li><a href="#">Settings 2</a> </li>
                                </ul>
                              </li>
                              <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                            </ul>
                            <div class="clearfix"></div>
                          </div>
                          <div class="x_content"> <br />
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="Title" required class="form-control col-md-7 col-xs-12" placeholder="Title">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <div id="gender" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="male">
                                      &nbsp; Male &nbsp; </label>
                                    <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="female" checked="">
                                      Female </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="birthday" class="date-picker form-control col-md-7 col-xs-12" required type="text" placeholder="Date Of Birth">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Height<span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="Height" name="Height" required class="form-control col-md-7 col-xs-12" placeholder="Height">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Weight<span class="required">*</span> </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" id="Weight" name="Weight" required class="form-control col-md-7 col-xs-12" placeholder="Weight">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Ethnic Group</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="EthnicGroup" class="form-control col-md-7 col-xs-12" type="text" name="EthnicGroup" placeholder="Ethnic Group">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Citizenship</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="Citizenship" class="form-control col-md-7 col-xs-12" type="text" name="Citizenship" placeholder="Citizenship">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Marital Status</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <div id="gender" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="male">
                                      &nbsp; Yes &nbsp; </label>
                                    <label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                      <input type="radio" name="gender" value="female" checked="">
                                      No </label>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Religion</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="Religion" class="form-control col-md-7 col-xs-12" type="text" name="Citizenship" placeholder="Religion">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Blood Type</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input id="BloodType" class="form-control col-md-7 col-xs-12" type="text" name="BloodType" placeholder="Blood Type">
                                </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <button type="submit" class="btn btn-primary">Cancel</button>
                                  <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                              </div>
                            </form>
                          </div>
                          <script type="text/javascript">
                        $(document).ready(function () {
                            $('#birthday').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4"
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        });
                    </script> 
                        </div>
                        <!-- End Personal Information --> 
                      </div>
                    </div>
                  </div>