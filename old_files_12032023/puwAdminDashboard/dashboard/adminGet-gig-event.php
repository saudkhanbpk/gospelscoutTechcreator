<?php 
	/* Return and Display User's Gigs to the admin page */

	/* Create DB connection to Query Database for Artist info */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

    /* Include config page */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

    /* Define user id var */
       $u_ID = $_GET['u_ID'];

	/* Retrieve all upcoming MANAGED gigs */    
            $gigStatus = 'active';
            $managedGigsQuery = 'SELECT gigdetails.gigId, gigdetails.gigDetails_gigName, gigdetails.gigDetails_setupTime, gigdetails.gigDetails_creationDate, gigdetails.gigDetails_gigStatus
                                 FROM gigdetails
                                 WHERE gigdetails.gigDetails_gigManLoginId = ?';
            try{
                $managedGigs = $db->prepare($managedGigsQuery);
                $managedGigs->bindParam(1,$u_ID);
                $managedGigs->execute(); 
            }
            catch(Exception $e){
                echo $e; 
            }
            $managedGigsResults = $managedGigs->fetchAll(PDO::FETCH_ASSOC); 
        /* END - Retrieve all upcoming MANAGED gigs */

        /* Retrieve all upcoming BOOKED gigs */    
            $artistStatus = 'confirmed';
            $bookedGigsQuery = 'SELECT gigdetails.gigId, gigdetails.gigDetails_gigName, gigdetails.gigDetails_setupTime, gigdetails.gigDetails_creationDate, gigdetails.gigDetails_gigStatus
                                 FROM gigartists
                                 INNER JOIN gigdetails on gigartists.gigId = gigdetails.gigId
                                 WHERE gigartists.gigArtists_userId = ? AND  gigartists.gigArtists_artistStatus = ?';
            try{
                $bookedGigs = $db->prepare($bookedGigsQuery);
                $bookedGigs->bindParam(1,$u_ID);
                $bookedGigs->bindParam(2,$artistStatus);
                $bookedGigs->execute(); 
            }
            catch(Exception $e){
                echo $e; 
            }
            $bookedGigsResults = $bookedGigs->fetchAll(PDO::FETCH_ASSOC); 
        /* END - Retrieve all upcoming BOOKED gigs */

        /* Retrieve all upcoming PENDING gigs */    
            $artistStatus = 'pending';
            $pendingGigsQuery = 'SELECT gigdetails.gigId, gigdetails.gigDetails_gigName, gigdetails.gigDetails_setupTime, gigdetails.gigDetails_creationDate, gigdetails.gigDetails_gigStatus
                                 FROM gigartists
                                 INNER JOIN gigdetails on gigartists.gigId = gigdetails.gigId
                                 WHERE gigartists.gigArtists_userId = ? AND gigartists.gigArtists_artistStatus = ?';
            try{
                $pendingGigs = $db->prepare($pendingGigsQuery);
                $pendingGigs->bindParam(1,$u_ID);
                $pendingGigs->bindParam(2,$artistStatus);
                $pendingGigs->execute(); 
            }
            catch(Exception $e){
                echo $e; 
            }
            $pendingGigsResults = $pendingGigs->fetchAll(PDO::FETCH_ASSOC); 
        /* END - Retrieve all upcoming PENDING gigs */ 

        /* Find Upcoming, Past, & Cancelled Gigs */
            $today = date_create(date());
            $today = date_format($today, 'Y-m-d H:i:s');

            /* Function to classify the managed, booked, and pending gigs as upcoming, past, or cancelled */
                function dateStatus($pageArray, $today){
                    foreach($pageArray as $manGig){
                        if($manGig['gigDetails_gigStatus'] == 'active'){
                            unset($manGig['gigDetails_gigStatus']);
                            if($manGig['gigDetails_setupTime'] > $today){
                                $manGig['gigDetails_setupTime'] = date_create($manGig['gigDetails_setupTime']);
                                $manGig['gigDetails_setupTime'] = date_format($manGig['gigDetails_setupTime'], 'm-d-Y');

                                $manGig['gigDetails_creationDate'] = date_create($manGig['gigDetails_creationDate']);
                                $manGig['gigDetails_creationDate'] = date_format($manGig['gigDetails_creationDate'], 'm-d-Y');
                                $gigs['upc'][] = $manGig;
                            }
                            elseif($manGig['gigDetails_setupTime'] <= $today){
                                $manGig['gigDetails_setupTime'] = date_create($manGig['gigDetails_setupTime']);
                                $manGig['gigDetails_setupTime'] = date_format($manGig['gigDetails_setupTime'], 'm-d-Y');

                                $manGig['gigDetails_creationDate'] = date_create($manGig['gigDetails_creationDate']);
                                $manGig['gigDetails_creationDate'] = date_format($manGig['gigDetails_creationDate'], 'm-d-Y');
                                 $gigs['pas'][] = $manGig; 
                            }
                        }
                        elseif($manGig['gigDetails_gigStatus'] == 'cancelled'){
                            unset($manGig['gigDetails_gigStatus']);
                            $manGig['gigDetails_setupTime'] = date_create($manGig['gigDetails_setupTime']);
                            $manGig['gigDetails_setupTime'] = date_format($manGig['gigDetails_setupTime'], 'm-d-Y');

                            $manGig['gigDetails_creationDate'] = date_create($manGig['gigDetails_creationDate']);
                            $manGig['gigDetails_creationDate'] = date_format($manGig['gigDetails_creationDate'], 'm-d-Y');
                             $gigs['can'][] = $manGig; 
                        }
                    }
                    return $gigs;
                }
            /* END - Function to classify the managed, booked, and pending gigs as upcoming, past, or cancelled */

            /* Store the managed, booked, pending, and cancelled gigs in appropriate vars */
                $mGigsOrganized =  dateStatus($managedGigsResults, $today); //managed
                $bGigsOrganized =  dateStatus($bookedGigsResults, $today); //booked
                $pGigsOrganized =  dateStatus($pendingGigsResults, $today); //pending
            /* END - Store the managed, booked, pending, and cancelled gigs in appropriate vars */

        /* END - Find Upcoming, Past, & Cancelled Gigs */

        	if($_GET['sel1'] == 'man'){
        		$requestedArray = $mGigsOrganized[$_GET['sel2']];
        	}
        	elseif($_GET['sel1'] == 'con'){
        		$requestedArray = $bGigsOrganized[$_GET['sel2']];
        	}
        	elseif($_GET['sel1'] == 'pen'){
        		$requestedArray = $pGigsOrganized[$_GET['sel2']];
        	}
        	
        	if($requestedArray){
        ?>
        		<table class="table table-striped text-left">
	        		<thead>
	                    <tr>
	                        <th scope="col">Gig Id</th>
	                        <th scope="col">Gig Name</th>
	                        <th scope="col">Gig Date</th>
	                        <th scope="col">Date Created</th>
	                    </tr>
	                </thead>
	                <tbody>
        <?php
            			foreach($requestedArray as $theseGigs){
        ?>
			                <tr class="text-truncate">
			                     <th scope="row"><a href="#"><?php echo $theseGigs['gigId']; ?></a></th>
			                     <td><a href="#"><?php echo $theseGigs['gigDetails_gigName']; ?></a></td>
			                     <td><a href="#"><?php echo $theseGigs['gigDetails_setupTime']; ?></a></td>
			                     <td><a href="#"><?php echo $theseGigs['gigDetails_creationDate']; ?></a></td>
			                 </tr>
        <?php 
	            		}
	    ?>
	    			</tbody>
	    		</table>
	    <?php
	        }
	        else{
	        	echo 'noResults';
	        }
?>