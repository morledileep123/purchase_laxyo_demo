@extends('../layouts.master')

@section('content')

{{-- <div class="container-fluid mb-2">
    <div class="row">
      <div class="col-12">
        <a href="{{ url()->previous() }}" class="main-title-w3layouts float-right mr-4"><i class="fa fa-arrow-left"></i> Back</a>
        <h5 class="main-title-w3layouts ml-4"> Create Vendor</h5>
      </div>
    </div>
</div> --}}


<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Products & Services</button>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#BankDetails">Bank Details</button> --}}
    {{-- <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ExcellSheet">Excel Sheet</button> --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please check your input code<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

             <div class="card">
              <div class="card-header">
                <h3 class="card-title">Single Vendor <small>Create form</small></h3>
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm float-right">Back</a>
                <button type="button" class="btn btn-success btn-sm float-right mr-2" data-toggle="modal" data-target="#ExcellSheet">Excel Sheet</button>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <form action="{{ route('vendor.store') }}" method="post" id="myForm">
                @csrf
                <div class="card-body">
                    <strong style="color:green;">Company Details</strong>
                    <div class="form-group">
                        <label for="company">Company Name <span style="color:red">*</span></label>
                        <input type="text" name="company" class="form-control" id="company" placeholder="Enter company name" value="{{old('company')}}">
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-4">
                        <label for="vendor_type" style="color: black !important" class="active">Vendor Type</label>
                            <select class="form-control" id="vendor_type" name="vendor_type">
                              <option hidden></option>
                              <option label="Supplier">Supplier</option>
                              <option label="Buyer">Buyer</option>
                              <option label="Both">Both</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="product">Product</label>
                            <input type="text" class="form-control" id="product" name="product" value="{{old('product')}}" placeholder="Product name">
                        </div>
                    </div>

                     <div class="row">
                        <div class="form-group col-md-4">
                            <label for="company_email">Company Email-id <span style="color:red">*</span></label>
                            <input type="email" class="form-control" id="company_email" name="company_email"  value="{{old('company_email')}}" placeholder="Company Email-id">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="company_mobile">Company mobile no</label>
                            <input type="text" class="form-control" id="company_mobile" name="company_mobile" value="{{old('company_mobile')}}" placeholder="Company Mobile no">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="gstin">GSTIN </label>
                            <input type="text" class="form-control" id="gstin" name="gstin" value="{{old('gstin')}}" placeholder="GSTIN">
                        </div>
                    </div>

                    <hr>
                    <strong style="color:green;">Address Details</strong>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="address1">Address 1 <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="address1" name="address1" value="{{old('address1')}}" placeholder="Address">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address2">Address 2</label>
                            <input type="text" class="form-control" id="address2" name="address2" value="{{old('address2')}}" placeholder="Address">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="gstin">Country <span style="color:red">*</span></label>
                            <select id="country" name="country" class="form-control">
                              
                              <option label="Afghanistan" value="Afghanistan">Afghanistan</option>
                              <option label="Albania" value="Albania">Albania</option>
                              <option label="Algeria" value="Algeria">Algeria</option>
                              <option label="American Samoa" value="American Samoa">American Samoa</option>
                              <option label="Andorra" value="Andorra">Andorra</option>
                              <option label="Angola" value="Angola">Angola</option>
                              <option label="Anguilla" value="Anguilla">Anguilla</option>
                              <option label="Antarctica" value="Antarctica">Antarctica</option>
                              <option label="Antigua and Barbuda" value="">Antigua and Barbuda</option>
                              <option label="Argentina" value="Argentina">Argentina</option>
                              <option label="Armenia" value="Armenia">Armenia</option>
                              <option label="Aruba" value="Aruba">Aruba</option>
                              <option label="Australia" value="Australia">Australia</option>
                              <option label="Austria" value="Austria">Austria</option>
                              <option label="Azerbaijan" value="Azerbaijan">Azerbaijan</option>
                              <option label="Bahamas" value="Bahamas">Bahamas</option>
                              <option label="Bahrain" value="Bahrain">Bahrain</option>
                              <option label="Bangladesh" value="Bangladesh">Bangladesh</option>
                              <option label="Barbados" value="Barbados">Barbados</option>
                              <option label="Belarus" value="Belarus">Belarus</option>
                              <option label="Belgium" value="Belgium">Belgium</option>
                              <option label="Belize" value="Belize">Belize</option>
                              <option label="Benin" value="Benin">Benin</option>
                              <option label="Bermuda" value="Bermuda">Bermuda</option>
                              <option label="Bhutan" value="Bhutan">Bhutan</option>
                              <option label="Bolivia" value="Bolivia">Bolivia</option>
                              <option label="Bosnia and Herzegovina" value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                              <option label="Botswana" value="Botswana">Botswana</option>
                              <option label="Bouvet Island" value="Bouvet Island">Bouvet Island</option>
                              <option label="Brazil" value="Brazil">Brazil</option>
                              <option label="British Indian Ocean Territory" value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                              <option label="British Virgin Islands" value="British Virgin Islands">British Virgin Islands</option>
                              <option label="Brunei Darussalam" value="Brunei Darussalam">Brunei Darussalam</option>
                              <option label="Bulgaria" value="Bulgaria">Bulgaria</option>
                              <option label="Burkina Faso" value="Burkina Faso">Burkina Faso</option>
                              <option label="Burundi" value="Burundi">Burundi</option>
                              <option label="Cambodia" value="Cambodia">Cambodia</option>
                              <option label="Cameroon" value="Cameroon">Cameroon</option>
                              <option label="Canada" value="Canada">Canada</option>
                              <option label="Cape Verde" value="Cape Verde">Cape Verde</option>
                              <option label="Cayman Islands" value="Cayman Islands">Cayman Islands</option>
                              <option label="Central African Republic" value="Central African Republic">Central African Republic</option>
                              <option label="Chad" value="Chad">Chad</option>
                              <option label="Chile" value="Chile">Chile</option>
                              <option label="China" value="China">China</option>
                              <option label="Christmas Island" value="Christmas Island">Christmas Island</option>
                              <option label="Cocos" value="Cocos">Cocos</option>
                              <option label="Colombia" value="Colombia">Colombia</option>
                              <option label="Comoros" value="Comoros">Comoros</option>
                              <option label="Congo - Brazzaville" value="Congo - Brazzaville">Congo - Brazzaville</option>
                              <option label="Congo-Kinshasa" value="Congo-Kinshasa">Congo-Kinshasa</option>
                              <option label="Cook Islands" value="Cook Islands">Cook Islands</option>
                              <option label="Costa Rica" value="Costa Rica">Costa Rica</option>
                              <option label="Croatia" value="Croatia">Croatia</option>
                              <option label="Cuba" value="Cuba">Cuba</option>
                              <option label="Cyprus" value="Cyprus">Cyprus</option>
                              <option label="Czech Republic" value="Czech Republic">Czech Republic</option>
                              <option label="Denmark" value="Denmark">Denmark</option>
                              <option label="Djibouti" value="Djibouti">Djibouti</option>
                              <option label="Dominica" value="Dominica">Dominica</option>
                              <option label="Dominican Republic" value="Dominican Republic">Dominican Republic</option>
                              <option label="East Timor" value="East Timor">East Timor</option>
                              <option label="Ecuador" value="Ecuador">Ecuador</option>
                              <option label="Egypt" value="Egypt">Egypt</option>
                              <option label="El Salvador" value="El Salvador">El Salvador</option>
                              <option label="Equatorial Guinea" value="Equatorial Guinea">Equatorial Guinea</option>
                              <option label="Eritrea" value="Eritrea">Eritrea</option>
                              <option label="Estonia" value="Estonia">Estonia</option>
                              <option label="Ethiopia" value="Ethiopia">Ethiopia</option>
                              <option label="Falkland Islands" value="Falkland Islands">Falkland Islands</option>
                              <option label="Faroe Islands" value="Faroe Islands">Faroe Islands</option>
                              <option label="Fiji" value="Fiji">Fiji</option>
                              <option label="Finland" value="Finland">Finland</option>
                              <option label="France" value="France">France</option>
                              <option label="French Guiana" value="French Guiana">French Guiana</option>
                              <option label="French Polynesia" value="French Polynesia">French Polynesia</option>
                              <option label="French Southern Territories" value="French Southern Territories">French Southern Territories</option>
                              <option label="Gabon" value="Gabon">Gabon</option>
                              <option label="Gambia" value="Gambia">Gambia</option>
                              <option label="Georgia" value="Georgia">Georgia</option>
                              <option label="Germany" value="Germany">Germany</option>
                              <option label="Ghana" value="Ghana">Ghana</option>
                              <option label="Gibraltar" value="Gibraltar">Gibraltar</option>
                              <option label="Greece" value="Greece">Greece</option>
                              <option label="Greenland" value="Greenland">Greenland</option>
                              <option label="Grenada" value="Grenada">Grenada</option>
                              <option label="Guadeloupe" value="Guadeloupe">Guadeloupe</option>
                              <option label="Guam" value="">Guam</option>
                              <option label="Guatemala" value="Guatemala">Guatemala</option>
                              <option label="Guinea" value="Guinea">Guinea</option>
                              <option label="Guinea-Bissau" value="Guinea-Bissau">Guinea-Bissau</option>
                              <option label="Guyana" value="Guyana">Guyana</option>
                              <option label="Haiti" value="Haiti">Haiti</option>
                              <option label="Heard and McDonald Islands" value="Heard and McDonald Islands">Heard and McDonald Islands</option>
                              <option label="Honduras" value="Honduras">Honduras</option>
                              <option label="Hong Kong" value="Hong Kong">Hong Kong</option>
                              <option label="Hungary" value="Hungary">Hungary</option>
                              <option label="Iceland" value="Iceland">Iceland</option>
                              <option label="India" value="India" selected="selected">India</option>
                              <option label="Indonesia" value="Indonesia">Indonesia</option>
                              <option label="Iran" value="Iran">Iran</option>
                              <option label="Iraq" value="Iraq">Iraq</option>
                              <option label="Ireland" value="Ireland">Ireland</option>
                              <option label="Israel" value="Israel">Israel</option>
                              <option label="Italy" value="Italy">Italy</option>
                              <option label="Ivory Coast" value="Ivory Coast">Ivory Coast</option>
                              <option label="Jamaica" value="Jamaica">Jamaica</option>
                              <option label="Japan" value="Japan">Japan</option>
                              <option label="Jordan" value="Jordan">Jordan</option>
                              <option label="Kazakhstan" value="Kazakhstan">Kazakhstan</option>
                              <option label="Kenya" value="Kenya">Kenya</option>
                              <option label="Kiribati" value="Kiribati">Kiribati</option>
                              <option label="Kuwait" value="Kuwait">Kuwait</option>
                              <option label="Kyrgyzstan" value="Kyrgyzstan">Kyrgyzstan</option>
                              <option label="Laos" value="Laos">Laos</option>
                              <option label="Latvia" value="Latvia">Latvia</option>
                              <option label="Lebanon" value="Lebanon">Lebanon</option>
                              <option label="Lesotho" value="Lesotho">Lesotho</option>
                              <option label="Liberia" value="Liberia">Liberia</option>
                              <option label="Libya" value="Libya">Libya</option>
                              <option label="Liechtenstein" value="Liechtenstein">Liechtenstein</option>
                              <option label="Lithuania" value="Lithuania">Lithuania</option>
                              <option label="Luxembourg" value="Luxembourg">Luxembourg</option>
                              <option label="Macau" value="Macau">Macau</option>
                              <option label="Macedonia" value="Macedonia">Macedonia</option>
                              <option label="Madagascar" value="Madagascar">Madagascar</option>
                              <option label="Malawi" value="Malawi">Malawi</option>
                              <option label="Malaysia" value="Malaysia">Malaysia</option>
                              <option label="Maldives" value="Maldives">Maldives</option>
                              <option label="Mali" value="Mali">Mali</option>
                              <option label="Malta" value="Malta">Malta</option>
                              <option label="Marshall Islands" value="Marshall Islands">Marshall Islands</option>
                              <option label="Martinique" value="Martinique">Martinique</option>
                              <option label="Mauritania" value="Mauritania">Mauritania</option>
                              <option label="Mauritius" value="Mauritius">Mauritius</option>
                              <option label="Mayotte" value="Mayotte">Mayotte</option>
                              <option label="Mexico" value="Mexico">Mexico</option>
                              <option label="Micronesia" value="Micronesia">Micronesia</option>
                              <option label="Moldova" value="Moldova">Moldova</option>
                              <option label="Monaco" value="Monaco">Monaco</option>
                              <option label="Mongolia" value="Mongolia">Mongolia</option>
                              <option label="Montenegro" value="Montenegro">Montenegro</option>
                              <option label="Montserrat" value="Montserrat">Montserrat</option>
                              <option label="Morocco" value="Morocco">Morocco</option>
                              <option label="Mozambique" value="object:205">Mozambique</option>
                              <option label="Myanmar" value="Myanmar">Myanmar</option>
                              <option label="Namibia" value="Namibia">Namibia</option>
                              <option label="Nauru" value="Nauru">Nauru</option>
                              <option label="Nepal" value="Nepal">Nepal</option>
                              <option label="Netherlands" value="Netherlands">Netherlands</option>
                              <option label="Netherlands Antilles" value="Netherlands Antilles">Netherlands Antilles</option>
                              <option label="New Caledonia" value="New Caledonia">New Caledonia</option>
                              <option label="New Zealand" value="New Zealand">New Zealand</option>
                              <option label="Nicaragua" value="Nicaragua">Nicaragua</option>
                              <option label="Niger" value="Niger">Niger</option>
                              <option label="Nigeria" value="Nigeria">Nigeria</option>
                              <option label="Niue" value="Niue">Niue</option>
                              <option label="Norfolk Island" value="Norfolk Island">Norfolk Island</option>
                              <option label="North Korea" value="North Korea">North Korea</option>
                              <option label="Northern Mariana Islands" value="Northern Mariana Islands">Northern Mariana Islands</option>
                              <option label="Norway" value="Norway">Norway</option>
                              <option label="Oman" value="Oman">Oman</option>
                              <option label="Pakistan" value="Pakistan">Pakistan</option>
                              <option label="Palau" value="Palau">Palau</option>
                              <option label="Panama" value="Panama">Panama</option>
                              <option label="Papua New Guinea" value="Papua New Guinea">Papua New Guinea</option>
                              <option label="Paraguay" value="Paraguay">Paraguay</option>
                              <option label="Peru" value="Peru">Peru</option>
                              <option label="Philippines" value="Philippines">Philippines</option>
                              <option label="Pitcairn" value="Pitcairn">Pitcairn</option>
                              <option label="Poland" value="Poland">Poland</option>
                              <option label="Portugal" value="Portugal">Portugal</option>
                              <option label="Puerto Rico" value="Puerto Rico">Puerto Rico</option>
                              <option label="Qatar" value="Qatar">Qatar</option>
                              <option label="Reunion" value="Reunion">Reunion</option>
                              <option label="Romania" value="Romania">Romania</option>
                              <option label="Russian Federation" value="Russian Federation">Russian Federation</option>
                              <option label="Rwanda" value="Rwanda">Rwanda</option>
                              <option label="S. Georgia and S. Sandwich Islands" value="S. Georgia and S. Sandwich Islands">S. Georgia and S. Sandwich Islands</option>
                              <option label="Saint Kitts and Nevis" value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                              <option label="Saint Lucia" value="Saint Lucia">Saint Lucia</option>
                              <option label="Saint Vincent and The Grenadines" value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                              <option label="Samoa" value="Samoa">Samoa</option>
                              <option label="San Marino" value="San Marino">San Marino</option>
                              <option label="Sao Tome and Principe" value="Sao Tome and Principe">Sao Tome and Principe</option>
                              <option label="Saudi Arabia" value="Saudi Arabia">Saudi Arabia</option>
                              <option label="Senegal" value="Senegal">Senegal</option>
                              <option label="Serbia" value="Serbia">Serbia</option>
                              <option label="Seychelles" value="Seychelles">Seychelles</option>
                              <option label="Sierra Leone" value="Sierra Leone">Sierra Leone</option>
                              <option label="Singapore" value="Singapore">Singapore</option>
                              <option label="Slovakia" value="Slovakia">Slovakia</option>
                              <option label="Slovenia" value="Slovenia">Slovenia</option>
                              <option label="Solomon Islands" value="Solomon Islands">Solomon Islands</option>
                              <option label="Somalia" value="Somalia">Somalia</option>
                              <option label="South Africa" value="South Africa">South Africa</option>
                              <option label="South Korea" value="South Korea">South Korea</option>
                              <option label="Soviet Union" value="Soviet Union">Soviet Union</option>
                              <option label="Spain" value="Spain">Spain</option>
                              <option label="Sri Lanka" value="Sri Lanka">Sri Lanka</option>
                              <option label="St. Helena" value="St. Helena">St. Helena</option>
                              <option label="St. Pierre and Miquelon" value="St. Pierre and Miquelon">St. Pierre and Miquelon</option>
                              <option label="Sudan" value="Sudan">Sudan</option>
                              <option label="Suriname" value="Suriname">Suriname</option>
                              <option label="Svalbard and Jan Mayen Islands" value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
                              <option label="Swaziland" value="Swaziland">Swaziland</option>
                              <option label="Sweden" value="Sweden">Sweden</option>
                              <option label="Switzerland" value="Switzerland">Switzerland</option>
                              <option label="Syria" value="Syria">Syria</option>
                              <option label="Taiwan" value="Taiwan">Taiwan</option>
                              <option label="Tajikistan" value="Tajikistan">Tajikistan</option>
                              <option label="Tanzania" value="Tanzania">Tanzania</option>
                              <option label="Thailand" value="Thailand">Thailand</option>
                              <option label="Timor-Leste" value="Timor-Leste">Timor-Leste</option>
                              <option label="Togo" value="Togo">Togo</option>
                              <option label="Tokelau" value="Tokelau">Tokelau</option>
                              <option label="Tonga" value="Tonga">Tonga</option>
                              <option label="Trinidad and Tobago" value="Trinidad and Tobago">Trinidad and Tobago</option>
                              <option label="Tunisia" value="Tunisia">Tunisia</option>
                              <option label="Turkey" value="Turkey">Turkey</option>
                              <option label="Turkmenistan" value="Turkmenistan">Turkmenistan</option>
                              <option label="Turks and Caicos Islands" value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                              <option label="Tuvalu" value="Tuvalu">Tuvalu</option>
                              <option label="Uganda" value="Uganda">Uganda</option>
                              <option label="Ukraine" value="Ukraine">Ukraine</option>
                              <option label="United Arab Emirates" value="United Arab Emirates">United Arab Emirates</option>
                              <option label="United Kingdom" value="United Kingdom">United Kingdom</option>
                              <option label="United States" value="United States">United States</option>
                              <option label="Uruguay" value="Uruguay">Uruguay</option>
                              <option label="US Minor Outlying Islands" value="US Minor Outlying Islands">US Minor Outlying Islands</option>
                              <option label="US Virgin Islands" value="US Virgin Islands">US Virgin Islands</option>
                              <option label="Uzbekistan" value="Uzbekistan">Uzbekistan</option>
                              <option label="Vanuatu" value="Vanuatu">Vanuatu</option>
                              <option label="Venezuela" value="Venezuela">Venezuela</option>
                              <option label="Viet Nam" value="Viet Nam">Viet Nam</option>
                              <option label="Wallis and Futuna Islands" value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
                              <option label="Western Sahara" value="Western Sahara">Western Sahara</option>
                              <option label="Yemen" value="Yemen">Yemen</option>
                              <option label="Yugoslavia" value="Yugoslavia">Yugoslavia</option>
                              <option label="Zaire" value="Zaire">Zaire</option>
                              <option label="Zambia" value="Zambia">Zambia</option>
                              <option label="Zimbabwe" value="Zimbabwe">Zimbabwe</option>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-3">
                            <label for="company_mobile">State</label>
                            <input list="browsers" name="state" id="browser" class="form-control">
                            <datalist id="browsers">
                                @foreach($states as $state)
                                <option value="{{$state->state_name}}">{{$state->state_name}}</option>
                                @endforeach
                            </datalist>
                            {{-- <select id="state" name="state" class="form-control">
                              <option value="" class="" selected="selected"></option>
                              <option label="Andaman and Nicobar Islands" value="Andaman and Nicobar IslandsN">Andaman and Nicobar Islands</option>
                              <option label="Andhra Pradesh" value="Andhra Pradesh">Andhra Pradesh</option>
                              <option label="Arunachal Pradesh" value="Arunachal Pradesh">Arunachal Pradesh</option>
                              <option label="Assam" value="Assam">Assam</option>
                              <option label="Bihar" value="Bihar">Bihar</option>
                              <option label="Chandigarh" value="Chandigarh">Chandigarh</option>
                              <option label="Chhattisgarh" value="Chhattisgarh">Chhattisgarh</option>
                              <option label="Dadra and Nagar Haveli" value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                              <option label="Daman and Diu" value="Daman and Diu">Daman and Diu</option>
                              <option label="Delhi" value="Delhi">Delhi</option>
                              <option label="Goa" value="Goa">Goa</option>
                              <option label="Gujarat" value="Gujarat">Gujarat</option>
                              <option label="Haryana" value="Haryana">Haryana</option>
                              <option label="Himachal Pradesh" value="Himachal Pradesh">Himachal Pradesh</option>
                              <option label="Jammu and Kashmir" value="Jammu and Kashmir">Jammu and Kashmir</option>
                              <option label="Jharkhand" value="Jharkhand">Jharkhand</option>
                              <option label="Karnataka" value="Karnataka">Karnataka</option>
                              <option label="Kerala" value="Kerala">Kerala</option>
                              <option label="Lakshadweep" value="Lakshadweep">Lakshadweep</option>
                              <option label="Madhya Pradesh" value="Madhya Pradesh" selected="selected">Madhya Pradesh</option>
                              <option label="Maharashtra" value="Maharashtra">Maharashtra</option>
                              <option label="Manipur" value="Manipur">Manipur</option>
                              <option label="Meghalaya" value="Meghalaya">Meghalaya</option>
                              <option label="Mizoram" value="Mizoram">Mizoram</option>
                              <option label="Nagaland" value="Nagaland">Nagaland</option>
                              <option label="Orissa" value="Orissa">Orissa</option>
                              <option label="Puducherry" value="Puducherry">Puducherry</option>
                              <option label="Punjab" value="Punjab">Punjab</option>
                              <option label="Rajasthan" value="Rajasthan">Rajasthan</option>
                              <option label="Sikkim" value="Sikkim">Sikkim</option>
                              <option label="Tamil Nadu" value="Tamil Nadu">Tamil Nadu</option>
                              <option label="Telangana State (TS)" value="Telangana State (TS)">Telangana State (TS)</option>
                              <option label="Tripura" value="Tripura">Tripura</option>
                              <option label="Uttar Pradesh" value="Uttar Pradesh">Uttar Pradesh</option>
                              <option label="Uttarakhand" value="Uttarakhand">Uttarakhand</option>
                              <option label="West Bengal" value="West Bengal">West Bengal</option>
                              <option label="Other" value="Other">Other</option>
                            </select> --}}
                        </div>
                        <div class="form-group col-md-3">
                            <label for="city">City <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="pin">PIN NO <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="pin" name="pin" value="{{old('pin')}}">
                        </div>
                    </div>

                    <hr>
                    <strong style="color:green;">Contact Person Details</strong>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="person_name">Name of Contact Person</label>
                            <input type="text" class="form-control" id="person_name" name="person_name" value="{{old('person_name')}}" placeholder="Contact Person name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="person_email">Contact Person Email-id</label>
                            <input type="email" class="form-control" id="person_email" name="person_email" value="{{old('person_email')}}" placeholder="Contact Person Email-id">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="person_mobile">Contact Person Phone no</label>
                            <input type="text" class="form-control" id="person_mobile" name="person_mobile" value="{{old('person_mobile')}}" placeholder="Contact mobile no">
                        </div>
                    </div>

                    <hr>
                    <strong style="color:green;">Bank Details</strong>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="account_no">Account No</label>
                            <input type="number" class="form-control" id="account_no" name="account_no" value="{{old('account_no')}}" placeholder="Account No">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="account_name">Account name</label>
                            <input type="text" class="form-control" id="account_name" name="account_name" value="{{old('account_name')}}" placeholder="Account Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="ifsc_code">IFSC Code</label>
                            <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="{{old('ifsc_code')}}" placeholder="Account IFSC Code">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="name_of_bank">Name of Bank and Branch</label>
                            <input type="text" class="form-control" id="name_of_bank" name="name_of_bank" value="{{old('name_of_bank')}}" placeholder="Name of Bank">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 5px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                        <div class="input-field col mb-3">
                            <select class="validate ipdis" id="vendor_type" name="vendor_type">
                              <option value="" class=""></option>
                              <option label="Supplier">Supplier</option>
                              <option label="Sub-Contractor">Sub-Contractor</option>
                              <option label="PRW">PRW</option>
                              <option label="Recruiting Agency">Recruiting Agency</option>
                              <option label="Mobile Service">Mobile Service</option>
                              <option label="Others">Others</option>
                              <option label="Both Supplier-SubCon">Both Supplier-SubCon</option>
                              <option label="RNM Vendor">RNM Vendor</option>
                              <option label="Charity Beneficiary">Charity Beneficiary</option>
                              <option label="Property Administrator">Property Administrator</option>
                              <option label="Property Owner">Property Owner</option>
                              <option label="Consultant">Consultant</option>
                              <option label="Transporter">Transporter</option>
                              <option label="Related Party">Related Party</option>
                            </select>
                            <label for="vendor_type" style="color: black !important" class="active">Type *</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-field col s6 mb-3">
                            <select class="validate ipdis" id="category" name="vendor_type">
                              <option value="" class=""></option>
                              @foreach($category as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                              @endforeach
                            </select>
                            <label for="vendor_type" style="color: black !important" class="active">Item Category *</label>
                        </div>

                        <div class="input-field col s6 mb-3">
                            <select class="validate ipdis" id="subcategory" name="vendor_type" disabled="">
                              <option value="" class=""></option>
                              @foreach($subcategory as $subcat)
                                <option label="{{ $subcat->category_id }}" value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                              @endforeach
                            </select>
                            <label for="vendor_type" style="color: black !important" class="active">Item Subcategory *</label>
                        </div>

                        <div class="input-field col mb-3">
                            <select class="validate ipdis" id="items" name="vendor_type" disabled="">
                              <option value="" class=""></option>
                              @foreach($items as $item)
                                <option label="{{ $item->brand }}" value="{{ $item->id }}">{{ $item->title }}</option>
                              @endforeach
                            </select>
                            <label for="vendor_type" style="color: black !important" class="active">Item Name *</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary float-right">Update</button> 
            </div>
        </div>
    </div>
</div>

<!-- Excell Modal -->
<div class="modal fade" id="ExcellSheet" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 5px">
            <div class="modal-header">
                <h4 class="text-center">Excel Import</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="container center">   
                    <form action="{{ route('vendor_excel_import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h6>1) Your Excel data should be in the format below.</h6>
                        <h6>2) In the Excel sheet, all columns should be filled. 
                         This is mandatory.</h6>                       
                        
                        <span class="text-muted">
                            <a class="text-center" href="{{ route('vendorExcel') }}" title="Excel Download">Click Here to download sheet format</a>
                        </span>
                        <br><br>
                         <input type="file" name="excel_data" id="imgupload">
                        <br><br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="BankDetails" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 5px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-field col">
                            <input type="text" id="account_holder_name" name="account_holder_name">
                            <label for="account_holder_name" class="active">Account Holder Name *</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-field col s6">
                            <input type="text" id="bank_name" name="bank_name">
                            <label for="bank_name" class="active">Bank Name *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="bank_branch" name="bank_branch">
                            <label for="bank_branch" class="active">Bank Branch *</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-field col s6">
                            <input type="text" id="bank_account_no" name="bank_account_no">
                            <label for="bank_account_no" class="active">Account Number *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="bank_ifsc_code" name="bank_ifsc_code">
                            <label for="bank_ifsc_code" class="active">IFSC Code *</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-field col">
                            <input type="text" id="bank_address" name="bank_address">
                            <label for="bank_address" class="active">Address *</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary float-right">Update</button> 
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
      var $optgroups = $('#subcategory > option');
      $("#category").on("change",function(){
        var selectedVal = this.value;
        $('#subcategory').removeAttr("disabled");
        $('#subcategory').html($optgroups.filter('[label="'+selectedVal+'"]'));
      });  

      var $opt = $('#items > option');
      $("#subcategory").on("change",function(){
        var selectedValue = this.value;
        $('#items').removeAttr("disabled");
        $('#items').html($opt.filter('[label="'+selectedValue+'"]'));
      });  
  });
</script>

<script type="text/javascript">
    function myFunction() {
      document.getElementById("myForm").reset();
    }
</script>