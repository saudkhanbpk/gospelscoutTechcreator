<style>
	html{
		scroll-behavior:smooth;
	}
	body {
		margin: 0;
	}
	.wrapper {
		display: grid;
		grid-template-columns: repeat(3,100%);
	}
	.item {
		padding:0 2px;
		transition: .5s ease;
	}
	.item:hover {
		margin: 0 40px;
		transform: scale(1.2);
	}

	section a {
		position: absolute;
		color: rgba(149,73,173,.7);
		text-decoration: none; 
		font-size: 6em;
		background: rgb(0,0,0);
		width: 80px;
		/*padding: 20px;*/
		text-align: center; 
		z-index: 1;
	}
	section a:nth-of-type(1){
		top:0;bottom:0;left:0;
		background: linear-gradient(-90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
	}
	section a:nth-of-type(2){
		top:0;bottom:0;right:0;
		background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
	}
	section {
		width: 100%;
		position:relative;
		display: grid;
		grid-template-columns: repeat(7, auto);
		margin: 20px 0;
	}
	section:nth-child(1){
		background: #fff; //#7be0ac;
	}
	
	/*section:nth-child(2){
		background: #b686e5;
	}
	section:nth-child(3){
		background: #f183a3;
	}*/

	.wrapTest{
		overflow: auto;
		/*white-space:nowrap;*/
	}

</style>



<div class="wrapper">
				<section id="section1">
					<a href="#section3"><</a>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>

					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<a href="#section2">></a>
				</section>
				<section id="section2">
					<a href="#section1"><</a>
					<div class="item">
						<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>

					<div class="item">
						<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/257/55934257mandelaPic1.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<a href="#section3">></a>
				</section>
				<section id="section3">
					<a href="#section2"><</a>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>

					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<div class="item">
						<img src="/newHomePage/upload/artist/258/13030atl.jpg" style="object-fit:cover; object-position:0,0;" width="100%" height="110"  alt="artist" /><!-- -->
					</div>
					<a href="#section1">></a>
				</section>
			</div> 