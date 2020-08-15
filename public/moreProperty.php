<?php
include_once '../models/Property.php';
if (isset($_GET['offset'])) {
    $offset = strip_tags($_GET['offset']);
    if (filter_var($offset, FILTER_VALIDATE_INT)) {?>
     
     <?php
                    $propertyObj = new Property();
                    $properties = $propertyObj->getPropertiesByLimit(6, $offset);
                    $totalProperties = $propertyObj->getTotalProperties();
                    if (mysqli_num_rows($properties) > 0) {
                        while ($propertyRow = mysqli_fetch_array($properties)) {
                            $images = explode(',',$propertyRow['images']);
                            ?>
                       	<div class=" row col-md-10 mb-5 pb-2 shadow bg-white" style=" padding-left:0px !important;margin-left:0px !important">
                           <div class="tab-content  col-md-5"  style=" padding:0px !important;margin:0px !important">
                                <div id="product1<?php echo $propertyRow['id']?>" class="tab-pane fade in show active">
                                    <img class=" col-md-12 d-flex align-items-center img-responsive"  style=" padding:0px !important;margin:0px !important;height:270px !important" src="<?php echo '../images/property/'.$images[0]?>" >
                                </div>

                                <?php if(count($images)>1):?>
                                <div id="product2<?php echo $propertyRow['id']?>" class="tab-pane fade">
                                    <img class=" col-md-12 d-flex align-items-center img-responsive" style=" padding:0px !important;margin:0px !important;height:270px !important" src="<?php echo '../images/property/'.$images[1]?>" >
                                </div>
                                <?php endif;?>
                                <?php if(count($images)>2):?>
                                <div id="product3<?php echo $propertyRow['id']?>" class="tab-pane fade">
                                    <img class=" col-md-12 d-flex align-items-center img-responsive" style=" padding:0px !important;margin:0px !important;height:270px !important" src="<?php echo '../images/property/'.$images[2]?>" >
                                </div>
                                <?php endif;?>
                                <div>
                                    <ul class="nav nav-tabs products-nav-tabs horizontal quick-view mt-10">
                                        <li style=" padding:0px !important;margin:0px !important"><a class="active" data-toggle="tab" href="#product1<?php echo $propertyRow['id']?>"><img src="<?php echo '../images/property/'.$images[0]?>" alt="" height="100px" width="100px" /></a></li>
                                        <?php if(count($images)>1):?>
                                            <li style=" padding:0px !important;margin:0px !important"><a data-toggle="tab" href="#product2<?php echo $propertyRow['id']?>"><img src="<?php echo '../images/property/'.$images[1]?>" alt="" height="100px" width="100px" /></a></li>
                                        <?php endif;?>
                                        <?php if(count($images)>2):?>
                                            <li style=" padding:0px !important;margin:0px !important"><a data-toggle="tab" href="#product3<?php echo $propertyRow['id']?>"><img src="<?php echo '../images/property/'.$images[2]?>" alt="" height="100px" width="100px"/></a></li>
                                        <?php endif;?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-7 heading-section pl-lg-5 pt-md-0 pt-5 mt-3">
                                <h3 class="mb-4"><?php echo $propertyRow['title'] ?></h3>
                                <p> <?php 
                                    $description = strip_tags( $propertyRow['description']);
                                    if (strlen($description) > 120) {
                                        $descData = substr($description, 0, 120) . "..".'<a href="#"  vacancyId="'.$propertyRow['id'].'" class="btn detailsBtn viewVacancy" vacancy-title="'.$propertyRow['title'].'" vacancy-desc="'.$propertyRow['description'].'"> View More </a>';
                                        echo $descData; 
                                        
                                    } else {
                                        $descData = $description. "..".'<a href="#"  vacancyId="'.$propertyRow['id'].'" class="btn detailsBtn viewVacancy" vacancy-title="'.$propertyRow['title'].'" vacancy-desc="'.$propertyRow['description'].'"> View More </a>';
                                        echo $descData; 
                                    }
                                ?></p>
                                <div>
                                    <p><span style="color:#007bff;">CONTACT US </span><span class="ion-ios-arrow-round-forward"></span> 
                                    <?php
                                    if($propertyRow['phone_one']!=null){
                                        echo $propertyRow['phone_one'].' '.'OR'.' '.$propertyRow['phone_two'];
                                    }else{
                                        echo $propertyRow['phone_one'];
                                    }?></p>
                                </div>    
                            </div>
                        </div>	
                       
                    <?php } } ?>
               
<?php
    }
    }   