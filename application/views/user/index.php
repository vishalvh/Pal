     <section id="home" class="home-slider">
                <div class="container">
                    <div class="flexslider">
                       
                           <?php // print_r($query);
                                            $cnt = 1;
                                            foreach ($query as $row) {
                                                ?>
                                                 <ul class="slides">
                            <li class="slide  str">
                 <?php //print_r($query); ?>              
                                <img onerror="this.src='<?php echo base_url(); ?>upload/<?php echo "No_image_available.jpg"; ?>'" src="<?= base_url() ?>/upload/<?php
                            if ( $row['logo']  != "") {
                                echo $row['logo'];
                            } else {
                                ?>images1.png <?php } ?>" >
                                <div class="flex-caption">
                                    <h1><?php echo ucwords($row['Title']); ?></h1>
                                    <div class="medium">
                                        <span><?php echo ucwords($row['Subtitle1']); ?></span>
                                    </div>
                                    <div class="small">
                                        <span><?php echo ucwords($row['Subtitle2']); ?></span>
                                    </div>
                                    <div class="small yellow">
                                        <span><?php echo ucwords($row['Details']); ?></span>
                                    </div>
                                    <?php $Active = $row['Active']; if($Active == 1){ ?>
                                    <div>
                                        <span><a class="cusmo-btn" href="<?php echo $row['Link']; ?>">Buy Now</a></span>

                                    </div>
									<?php } ?>
                                </div>
                            </li>
                            </ul>
<?php $cnt++; } ?>

                        
                    </div>
                </div>
            </section>

            <section class="section-home-products">
                <div class="container">
                    <div class="controls-holder nav-tabs">
                        <ul class="list-inline">
                            <li class="active"><a data-toggle="tab" href="#hot-products">Hot products</a></li>
                            <li><a data-toggle="tab" href="#new-products">New products</a></li>
                            <li><a data-toggle="tab" href="#best-sellers">Best sellers</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="hot-products" class="products-holder active tab-pane ">
                            <div class="row">
                                <?php foreach ($product_list->data as $product){ 
                                    $test = (array) $product;
                                    $keys = str_replace( ' ', '', array_keys( $test ) );
                                    $newProduct = array_combine( $keys, array_values( $test ) );
                                    ?>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="product-item">

                                        <a href="product-detail/<?php echo $newProduct['PrimaryID']; ?>">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product1.jpg" />
                                            <h1><?php echo $newProduct['Name']; ?></h1>
                                        </a>
                                        <div class="tag-line">
                                            <?php 
                                                foreach ($newProduct['Categories'] as $cat){ ?>
                                            <span><?php echo $cat; ?></span>
                                                <?php } ?>
                                            
                                        </div>
                                        <div class="price">
                                            Nett Price : $<?php echo $newProduct['NettPriceExcVAT']; ?><br>
                                            RRP Price : $<?php echo $newProduct['RRPPriceExcVAT']; ?>
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail/<?php echo $newProduct['PrimaryID']; ?>">add to cart</a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="load-more-holder">
                                <input type="button" onclick="get_more_product('<?php echo $product_list->maxId; ?>');" class="load-more" value="load more hot products" name="getextra">
                            </div>

                        </div>




                        <div id="new-products" class="products-holder  tab-pane ">
                           
                         <!-- <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                   <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                   <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                                </div>
                            </div>-->
                            <!--<div class="load-more-holder">
                                <a href="#new-products" class="load-more">
                                    load more hot products
                                </a>
                            </div>-->
                        </div>
                    </div>
                    <div id="best-sellers" class="products-holder  tab-pane ">
                        <div class="row">
                     <!--       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                               <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                               <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                               <div class="product-item">
                                        <a href="#">
                                            <img alt="" src="<?php echo base_url(); ?>design/images/product2.jpg" />
                                            <h1>Videx</h1>
                                        </a>
                                        <div class="tag-line">
                                            <span>Matrix product</span>
                                            <span>Audio & Video Door Entry</span>
                                        </div>
                                        <div class="price">
                                            $122.00
                                        </div>
                                        <a class="cusmo-btn add-button" href="product-detail">add to cart</a>
                                    </div>
                            </div>
							
							-->
                        </div>
						
						
                       <!-- <div class="load-more-holder">
                            <a href="#best-sellers" class="load-more">
                                load more hot products
                            </a>
                        </div>-->
                    </div>

                </div>
            </section>
            <section class="section-carousel">
                <div class="container">
                    <div class="nav-holder">
                            <a  class="carousel-nav carousel_prev" href="#prev"><i class="icon-angle-left"></i></a>
                            <a  class="carousel-nav carousel_next" href="#next"><i class="icon-angle-right"></i></a>
                        </div>
                    
                    <div class="carousel-holder">
                    <div id="clients-carousel" class="clients-holder carousel">

                        <div class="client-item">
                            
                            <a href="#">
                            <img alt="" src="<?php echo base_url(); ?>design/images/logo_blk.png" />
                            </a>

                        </div>
                        
                         <div class="client-item">
                            
                            <a href="#">
                            <img alt="" src="<?php echo base_url(); ?>design/images/logo_blk.png" />
                            </a>

                        </div>
                        
                         <div class="client-item">
                            
                            <a href="#">
                            <img alt="" src="<?php echo base_url(); ?>design/images/logo_blk.png" />
                            </a>

                        </div>
                        
                         <div class="client-item">
                            
                            <a href="#">
                            <img alt="" src="<?php echo base_url(); ?>design/images/logo_blk.png" />
                            </a>

                        </div>
                        
                         <div class="client-item">
                            
                            <a href="#">
                            <img alt="" src="<?php echo base_url(); ?>design/images/logo_blk.png" />
                            </a>

                        </div>
                        
                           <div class="client-item">
                            
                            <a href="#">
                            <img alt="" src="<?php echo base_url(); ?>design/images/logo_blk.png" />
                            </a>

                        </div>
                           <div class="client-item">
                            
                            <a href="#">
                            <img alt="" src="<?php echo base_url(); ?>design/images/logo_blk.png" />
                            </a>

                        </div>
                        
                           <div class="client-item">
                            
                            <a href="#">
                            <img alt="" src="<?php echo base_url(); ?>design/images/logo_blk.png" />
                            </a>

                        </div>
                    </div>
                    </div>
                </div>
            </section>

<script>
    function get_more_product(maxId){
        alert(maxId);
    }
    </script>