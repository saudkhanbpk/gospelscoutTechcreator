



<!--<input type="radio" name="loginmaster[sUserType]" id="group-type" class="band-type u-type" value="group">-->
<input type="file" class="custom-file-input" name="sProfileName" id="sProfileName">
<input type="text" name="test" id="test">
<script src="https://www.stage.gospelscout.com/js/jquery-1.11.1.min.js"></script>
<script>
    function testFunct(){
        console.log('wtf');
    }
    $('#test').change(testFunct);//function(e){}
    // document.getElementById('group-type').addEventListener('click', testFunct);
    // document.getElementById('group-type').addEventListener('click', testFunct, false);
    // console.log( document.getElementById('group-type').addEventListener('click', testFunct) );
</script>