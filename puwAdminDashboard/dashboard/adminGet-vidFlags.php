<?php 
	/* Admin Get video Flags */

	/* Create DB connection to Query Database for Artist info */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/newHomepage/include/dbConnect.php');

    /* Include config page */
        include(realpath($_SERVER['DOCUMENT_ROOT']) . '/common/config.php');

    /* Define user id var */
       $u_ID = $_GET['u_ID'];
       $vid_ID  = $_GET['vid_ID'];

	/* Query Database for Artist's video flags */
            $getFlagsQuery = 'SELECT artistvideoreportmaster.*, usermaster.sFirstName, usermaster.sLastName 
                              From artistvideoreportmaster 
                              INNER JOIN usermaster on usermaster.iLoginID = artistvideoreportmaster.reporterId
                              WHERE artistvideoreportmaster.artistId = ? AND artistvideoreportmaster.vidId = ?';

            try{
                $getFlags = $db->prepare($getFlagsQuery);
                $getFlags->bindParam(1, $u_ID);
                $getFlags->bindParam(2, $vid_ID);
                $getFlags->execute(); 
                $getFlagsResults = $getFlags->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e){
                echo 'Problem retrieving artist video flags: ' . $e; 
            }

            $numbOfFlags = count($getFlagsResults);
        /* END - Query Database for Artist's video flags */

    /* If Array is not empty, display flags in a table */
    if(count($getFlagsResults) > 0){
?>
    	<table class="table table-striped text-left">
            <thead>
                <tr>
                    <th scope="col">Flag Id</th>
                    <th scope="col">Flagger</th>
                    <th scope="col">FLag Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($getFlagsResults as $fResult){
                        $flagDate = date_create($fResult['dateTime']);
                        $flagDate = date_format($flagDate, "m-d-Y @ H:i:s");
                ?>
                         <tr class="text-truncate">
                             <th scope="row"><?php echo $fResult['id']; ?></th>
                             <td><?php echo $fResult['sFirstName']; ?></td>
                             <td><?php echo $flagDate; ?></td>
                             <td><a href="#" class="text-gs">View Flag</a></td>
                         </tr>
                <?php }
                ?>
            </tbody>
        </table>
<?php
	}
    /* END - If Array is not empty, display flags in a table */
?>