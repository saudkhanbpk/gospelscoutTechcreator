<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/header.php';?>
<?php
if ( isset($_GET['type']) == 'cancel') {		

	if ( $objsession->get('gs_book_id') > 0 ) {
		$obj->delete('bookingmaster',"iBookingID = ".$objsession->get('gs_book_id'));
		$objsession->remove('gs_book_id');
	}
	
	if ( $objsession->get('gs_event_id') > 0 ) {
		$obj->delete('eventbooking',"iBookingID = ".$objsession->get('gs_event_id'));
		$objsession->remove('gs_event_id');
	}
}
?>
<section style="padding-top:50px;">
  <div class="container ">
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12 big-title text-center">
        <h3>Sorry, Your Booking is cancelled.</h3>
      </div>
    </div>
  </div>
</section>
<?php require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/include/footer.php';?>