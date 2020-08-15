<?php
ob_start();
session_start();
session_regenerate_id();
$msg = '';
$type = 'info';
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if($type=='error'){
        $type='danger';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Serve Global | Donation</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- ================= Favicon ================== -->
        <link rel="icon" sizes="72x72" href="dist/img/favicon.ico">
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900%7COpen+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Bootsrap css-->
        <link rel="stylesheet" href="dist/css/bootstrap.min.css">
        <script src="dist/js/modernizr-2.8.3.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <style>
            .help-block{
                margin-bottom:0;
            }
         
        #spinnerImage{
            position: fixed;
            margin: 20%;
        }
      
        #loading {
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: fixed;
            display: block;
            opacity: 0.7;
            background-color: #fff;
            z-index: 99;
            text-align: center;
        }

        #loading-image {
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 100;
        }
   
        </style>
    </head>
    <body>
        <div id="loading">
        <img id="loading-image" src="dist/img/loader.gif" alt="Loading..." class="no-print" />
    </div>
        <div class="container">
           <div class="row">
            <div class="col-sm-2 col-md-2 col-lg-2"></div>
            <div class="col-md-8">
                <form class="form-horizontal form-group" action="include/charge.php" method="post" id="payment-form">
                    <div class="pane panel-default" style="margin-top: 10px; box-shadow: 5px 0px 40px rgba(0, 0, 0, .2);">
                        <div class="panel-heading">
                            <h2 style="text-align: center;"><strong>Donate Serve Global</strong></h2>
                            <a href="index" class="btn btn-primary visible-xs visible-sm" ><span class="fa fa-home"></span> Return to Home page</a>
                        </div>
                        <div class="panel-body">
                                              <?php
        if ($msg != '') {
            ?>
            <div class="alert alert-<?php echo trim($type); ?>" role='alert' id='artMsg'> <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span>
                    <span class='sr-only'>Close</span></button> <?php echo $msg; ?>
            </div>
            <?php
        }
        ?>
                            <div class="form-group">
                                <label for="card-element" class="col-sm-2 control-label">
                                    Credit or Debit Card<span class="required" style="color: red;" >*</span>
                                </label>
                                <div id="card-element" class="col-sm-10">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors. -->
                                <br>
                                <div id="card-errors" role="alert" class="help-block"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="amount">Amount <span class="required" style="color: red;">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter the amount you want to donate e.g $50" style="height: 40px;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">

                                </div>
                                <div class="col-sm-4 col-xs-7">
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="" name="option">Make this donation every</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-5">

                                    <select class="form-control" id="interval" name="interval">
                                        <option value="month">Month</option>
                                        <option value="quarter">Quarter</option>
                                        <option value="semister">6 Month</option>
                                        <option value="year">Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="name">Name <span class="required" style="color: red;">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your name on the card" style="height: 40px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="email">Email<span class="required" style="color: red;">*</span> </label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="donateEmail" id="email" placeholder="Enter email" style="height: 40px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country" class="col-sm-2 control-label">Country <span class="required" style="color: red;">*</span></label>
                                <div class="col-sm-10">
                                    <select name="country" id="country" class="form-control form-control" style="height: 40px;">

                                        <option value="Afghanistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Colombi">Colombi</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo (Brazzaville)">Congo (Brazzaville)</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor (Timor Timur)">East Timor (Timor Timur)</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia, The">Gambia, The</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iran">Iran</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea, North">Korea, North</option>
                                        <option value="Korea, South">Korea, South</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libya">Libya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macedonia">Macedonia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Micronesia">Micronesia</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau">Palau</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                        <option value="Saint Lucia">Saint Lucia</option>
                                        <option value="Saint Vincent">Saint Vincent</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syria</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vatican City">Vatican City</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="commentInput" class="col-sm-2 control-label">Comment</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="commentInput" name="comment" row="5" placeholder="Why you donate?"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="anonymous"> Donate Anonymously</label>
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <label  class="col-sm-3 control-label"></label>
                                <div class="col-sm-9">
                                      <div class="g-recaptcha" data-sitekey="6LdAnfcUAAAAADqUtWZgEExIPRDc-G7xJn5JnbkZ"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-warning"><span class="fa fa-send"></span> Donate </button> &nbsp;&nbsp;&nbsp;
                                    <a href="index" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </div>

                    </div>


                </form> 
            </div>
              <div class="col-sm-2 col-md-2 col-lg-2"></div>
            </div>
        </div>

        <!-- == jQuery Librery == -->
        <script src="dist/js/jquery-2.2.4.min.js"></script>
        <!-- == Bootsrap js File == -->
        <script src="dist/js/bootstrap.min.js"></script>
        <script src="dist/js/charge.js"></script>
        <!-- bootstrap validator  -->
        <script src="dist/js/bootstrapValidator.min.js"></script>
         <script src="https://www.google.com/recaptcha/api.js" async defer></script>
         <script>
    $(document).ready(function () {
        $(window).load(function() {
            $('#loading').hide();
        });
     
    });

</script>
    </body>
</html>
