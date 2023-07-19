<?php
ob_start("ob_gzhandler");
session_start();
$mysqli = new mysqli("localhost", "root", "mYsiTTi341Com", "mysitti_live"); 
?>
<?php include("new-header.php"); ?>
<?php include("new-menu.php"); ?>
	<div class="banner-sec">
		<div class="container n-contain">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="banner-content">
						<h2>The world is not in your books and maps, it’s out there...</h2>
						<p>At vero eos et accusamus et iusto odio dignissimos ducimus blanditiis praesentium voluptatum deleniti atque corrupti similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. </p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="search-sec">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="search-content">
						<ul>
							<li>
								<div class="form-group">
									<img class="nav-img" src="https://mysittivacations.com/assets/images/bed.png"> <input type="Name" class="form-control" id="exampleFormControlInput1" placeholder="Where are you going?">
								</div>
							</li>
							<li>
								<div class="form-group">
									<img class="nav-img" src="https://mysittivacations.com/assets/images/calender.png"> <input type="Name" class="form-control" id="exampleFormControlInput1" placeholder="Check-in    -     Check-out">
								</div>
							</li>
							<li>
								<div class="form-group">
								<img class="nav-img" src="https://mysittivacations.com/assets/images/cust.png">
									<select class="custom-select form-control" id="searchTeam">
                                        <option selected="">2 adults  .  0 children   .   1 room</option>
                                        <option>2 adults  .  0 children   .   1 room</option>
                                        <option>2 adults  .  0 children   .   1 room</option>
                                    </select>
								</div>
							</li>
							<li>
								<a href="#"> <img class="nav-img" src="https://mysittivacations.com/assets/images/lens.png"> Search </a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("new-category.php"); ?>
	
	<div class="deals-sec">
		<div class="container n-contain">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="heading-content">
						<div class="content-sec">
						<h2>Cool Flight Deals</h2>
						<p>Checkout what we found for you from</p>
						</div>
					</div>
				</div>
                <div class="col-lg-12 col-12">
					<div class=" back demo-slider">     
						<div class="slider-sec">
						  	<section class="partner-logos slider">
							  	<?php
				                    $sql = "SELECT name,image_url FROM popular_cities limit 10";
				                    $result = $mysqli->query($sql);
				                    foreach ($result as $key => $value) {
				                ?>
									<div class="slide">
											<div class="slider-wrap new">
												<div class="dicount-offer-sec">
													<a onclick="reloadLandingPage('<?php echo $value['name']; ?>',this)" href="random_deals.php?flag=Flights&from_name=<?php echo $value['name']; ?>&from_to=United state">

													<img class="nav-img" src="<?php echo $value['image_url']; ?>" alt="<?php echo $value['name']; ?>" >
													<div class="dis-content">
														<h3> <?php echo $value['name']; ?></h3>
														<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
													</div>
													</a>
												</div>

											</div>
									</div>
								<?php } ?>
						   	</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="deals-sec dicount-sec">
		<div class="container n-contain">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="heading-content">
						<div class="content-sec">
							<h2>Amazing All-Inclusive Discounts</h2>
							<p>Checkout what we found for you from</p>
						</div>
						<div class="view-all-sec">
							<a href="#">View All</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-1.png">
						<div class="dis-content">
							<h3> San José del Cabo, B.C.S.</h3>
							<p>4- or 6-Night All-Inclusive Krystal Grand Los Cabos Stay, </p>
							<ul>
								<li><img class="nav-img" src="https://mysittivacations.com/assets/images/loc.png"> San José del Cabo, B.C.S. </li>
								<li><img class="nav-img" src="https://mysittivacations.com/assets/images/dollar.png"> $871.43(37% Off) -  <span>$549.00</span> </li>
								<li><img class="nav-img" src="https://mysittivacations.com/assets/images/sale.png"> Sales Ends: 02/03/2022 </li>
							</ul>
							<a href="#" class="left-bar-sec"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-2.png">
						<div class="dis-content">
							<h3> San José del Cabo, B.C.S.</h3>
							<p>4- or 6-Night All-Inclusive Krystal Grand Los Cabos Stay, </p>
							<ul>
								<li><img class="nav-img" src="https://mysittivacations.com/assets/images/loc.png"> San José del Cabo, B.C.S. </li>
								<li><img class="nav-img" src="https://mysittivacations.com/assets/images/dollar.png"> $871.43(37% Off) -  <span>$549.00</span> </li>
								<li><img class="nav-img" src="https://mysittivacations.com/assets/images/sale.png"> Sales Ends: 02/03/2022 </li>
							</ul>
							<a href="#" class="left-bar-sec"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-3.png">
						<div class="dis-content">
							<h3> San José del Cabo, B.C.S.</h3>
							<p>4- or 6-Night All-Inclusive Krystal Grand Los Cabos Stay, </p>
							<ul>
								<li><img class="nav-img" src="https://mysittivacations.com/assets/images/loc.png"> San José del Cabo, B.C.S. </li>
								<li><img class="nav-img" src="https://mysittivacations.com/assets/images/dollar.png"> $871.43(37% Off) -  <span>$549.00</span> </li>
								<li><img class="nav-img" src="https://mysittivacations.com/assets/images/sale.png"> Sales Ends: 02/03/2022 </li>
							</ul>
							<a href="#" class="left-bar-sec"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="deals-sec">
		<div class="container n-contain">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="heading-content">
						<div class="content-sec">
							<h2>Are You Looking To Travel In The US</h2>
							<p>Take a look at these US travel destination ideas</p>
						</div>
						<div class="view-all-sec">
							<a href="#">View All</a>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-12">
					<div class="travel-sec">
						<a href="#" class="heart-sec"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
						<img class="" src="https://mysittivacations.com/assets/images/img-4.png">
						<h3>los angeles<h3>
					</div>
				</div>
				<div class="col-md-3 col-12">
					<div class="travel-sec">
						<a href="#" class="heart-sec"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
						<img class="" src="https://mysittivacations.com/assets/images/img-5.png">
						<h3>los angeles<h3>
					</div>
				</div>
				<div class="col-md-3 col-12">
					<div class="travel-sec">
						<a href="#" class="heart-sec"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
						<img class="" src="https://mysittivacations.com/assets/images/img-6.png">
						<h3>los angeles<h3>
					</div>
				</div>
				<div class="col-md-3 col-12">
					<div class="travel-sec">
						<a href="#" class="heart-sec"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
						<img class="" src="https://mysittivacations.com/assets/images/img-7.png">						
						<h3>los angeles<h3>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="deals-sec sea">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="sea-header">
						<h2>All the good memories of 2021</h2>
						<p>At vero eos et accusamus et iusto odio dignissimos ducimus blanditiis praesentium voluptatum deleniti atque corrupti. </p>
						<a href="#">see the flashbacks</a>
						<img class="" src="https://mysittivacations.com/assets/images/sea-img.png">
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="deals-sec dicount-sec no-shad">
		<div class="container n-contain">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="heading-content">
						<div class="content-sec">
							<h2>See Beautiful America</h2>
							<p>Enjoy the scenic views of National Parks</p>
						</div>
						<div class="view-all-sec">
							<a href="#">View All</a>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-8.png">
						<div class="dis-content">
							<h3> 7 day southwest high</h3>
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-9.png">
						<div class="dis-content">
							<h3> 3 day national parks</h3>
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-10.png">
						<div class="dis-content">
							<h3> 3 day national parks</h3>
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="deals-sec beach">
		<div class="container n-contain">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="heading-content">
						<div class="content-sec">
							<h2>Relaxing Beach Gateways</h2>
							<p>Here are some beautiful destinations</p>
						</div>
						<div class="view-all-sec">
							<a href="#">View All</a>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-11.png">
						<div class="dis-content">
							<h3> panama city, flori</h3>
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-12.png">
						<div class="dis-content">
							<h3> honolulu, hawaii</h3>
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-13.png">
						<div class="dis-content">
							<h3>kailua, hawaii</h3>
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-14.png">
						<div class="dis-content">
							<h3>fort myers beach</h3>
							<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="deals-sec dicount-sec addver">
		<div class="container n-contain">
			<div class="row">
				<div class="col-md-6 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-15.png">
					</div>
				</div>
				<div class="col-md-6 col-12">
					<div class="dicount-offer-sec">
						<img class="nav-img" src="https://mysittivacations.com/assets/images/img-16.png">
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="blog-sec deals-sec beach">
		<div class="container  n-contain">
			<div class="row">
				<div class="col-md-12 col-12">
					<div class="heading-content">
						<div class="content-sec">
							<h2>Relaxing Beach Gateways</h2>
							<p>Here are some beautiful destinations</p>
						</div>
						<div class="view-all-sec">
							<a href="#">View All</a>
						</div>
					</div>
				</div>
				<div class="col-lg-12 col-12">
					<div class=" back demo-slider">     
						<div class="slider-sec">
							<section class="customer-logos slider">
								<div class="slide">
									<div class="slider-wrap">
										<div class="dicount-offer-sec">
											<img class="nav-img" src="https://mysittivacations.com/assets/images/img-14.png">
											<div class="dis-content">
												<div class="date-sec">
													<p><img src="https://mysittivacations.com/assets/images/date.png"> Jan 23, 2020</p>
												</div>
												<h3>Lorem ipsum dolor sit amet al harun sed ut prestics</h3>
												<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
												<a href="#"><img src="https://mysittivacations.com/assets/images/arrow.png"></a>
											</div>
										</div>
									</div>
								</div>
								<div class="slide">
									<div class="slider-wrap">
										<div class="dicount-offer-sec">
											<img class="nav-img" src="https://mysittivacations.com/assets/images/img-14.png">
											<div class="dis-content">
												<div class="date-sec">
													<p><img src="https://mysittivacations.com/assets/images/date.png"> Jan 23, 2020</p>
												</div>
												<h3>Lorem ipsum dolor sit amet al harun sed ut prestics</h3>
												<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
												<a href="#"><img src="https://mysittivacations.com/assets/images/arrow.png"></a>
											</div>
										</div>
									</div>
								</div>
								<div class="slide">
									<div class="slider-wrap">
										<div class="dicount-offer-sec">
											<img class="nav-img" src="https://mysittivacations.com/assets/images/img-14.png">
											<div class="dis-content">
												<div class="date-sec">
													<p><img src="https://mysittivacations.com/assets/images/date.png"> Jan 23, 2020</p>
												</div>
												<h3>Lorem ipsum dolor sit amet al harun sed ut prestics</h3>
												<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
												<a href="#"><img src="https://mysittivacations.com/assets/images/arrow.png"></a>
											</div>
										</div>
									</div>
								</div>
								<div class="slide">
									<div class="slider-wrap">
										<div class="dicount-offer-sec">
											<img class="nav-img" src="https://mysittivacations.com/assets/images/img-14.png">
											<div class="dis-content">
												<div class="date-sec">
													<p><img src="https://mysittivacations.com/assets/images/date.png"> Jan 23, 2020</p>
												</div>
												<h3>Lorem ipsum dolor sit amet al harun sed ut prestics</h3>
												<p>At vero eos et accusamus et iusto odio dignissimos ducimus </p>
												<img src="https://mysittivacations.com/assets/images/arrow.png">
											</div>
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="deals-sec blue-back">
		<div class="container  n-contain">
			<div class="row">
				<div class="col-md-12 col-12">
					<ul>
						<li>
							<div class="heading-content">
								<div class="content-sec">
									<h2>Where can I rent a bicycle?</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex </p>
									<a href="#">find answer in the forums</a>
								</div>
							</div>
						</li>
						<li>
							<img src="https://mysittivacations.com/assets/images/img-21.png">
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php include("new-footer.php"); ?>	
	