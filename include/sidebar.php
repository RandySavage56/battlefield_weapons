					<div class="row">
						<div class="col-md-3 col-xs-12">
							<button class="hamburgerbutton">&#9776</button>
							<div class="hamburgersidebar">
								<div class="hamburgersidebar-header"></div>
								<div class="hamburgersidebar-body">
									<div class="sidebar row">
									<div class="col-md-12 col-xs-12">
									<h3 class="lastweapons">Dernières armes</h3>
									<?php

									$select=$db->prepare("SELECT*FROM weapons ORDER BY id LIMIT 0,3");
										$select->execute();

										while($s=$select->fetch(PDO::FETCH_OBJ)){

												$length = 50;

												$description = $s->description;

												$new_description = substr($description, 0, $length).'...';

												$description_finale = wordwrap($new_description,25,'<br/>',true);


											?>
												<div style="text-align: center;">
												<img height='80' width='100'src="admin/imgs/<?php echo $s->name;?>.jpg">
												<h2><?php echo $s->name; ?></h2><br/>
												<h5><?php echo $description_finale; ?></h5><br/>
												<h4><?php echo $s->price; ?> €</h4><br/>
												</div>
												<br/><br/>

											<?php
										}
											?>
										</div>
								</div>
							</div>
							<div class="hamburgeroverlay"></div>
						</div>
				
							
				
