<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ThreeJs Sample</title>
    <?php
if (isset($_GET['q'])) {
  $GLOBALS['q'] = intval($_GET['q']);
  echo "<script>var level = $GLOBALS[q];</script>";
  $GLOBALS['q']++;
  if ($GLOBALS['q'] == 4) {
    $GLOBALS['q'] = 1;
   }
}
else{
  echo "<script>var level = 1;</script>";
  $GLOBALS['q'] = 2;
}
?>
    <div class="wrapper">
     <p>Move: W-A-S-D</p>
     <button type="button" id="refresh" onclick="document.location.reload()">Try Again</button>
    <a href = <?php  echo "index.php?q=$GLOBALS[q]";?>> <button type="button" id="win" >You Win! Next Level!</button></a>
   </div>
   <style>
     body{
       margin: 0px;
       overflow: hidden;
     }
     p{
       position: absolute;
       top: 0%;
       left: 80%;
       z-index: 100;
       display: block;
       color: white;
     }
     #refresh, #win {
         position: absolute;
         top: 50%;
         left: 50%;
         width: 150px;
         height: 150px;
         background-color: darkgreen;
         border-color: darkgreen;
         z-index: 100;
         display: none;
         font-size: 25px;
       }
   </style>
  </head>
  <body>
<script src="lib/three.js"></script>
<script src="lib/OrbitControls.js"></script>
<script src="lib/GLTFLoader.js"></script>
<script src="lib/cannon.js"></script>
<script src="lib/PointerLockControls.js"></script>

<script>
  console.log(level);
(function(){var script=document.createElement('script');script.onload=function(){var stats=new Stats();document.body.appendChild(stats.dom);requestAnimationFrame(function loop(){stats.update();requestAnimationFrame(loop)});};script.src='//mrdoob.github.io/stats.js/build/stats.min.js';document.head.appendChild(script);})()
  var timeStep=1/60;
  var scene = new THREE.Scene();
  var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
  var renderer = new THREE.WebGLRenderer();
  renderer.setSize(window.innerWidth, window.innerHeight)
  document.body.appendChild(renderer.domElement);
  var goal;
  var rotating=true;
  var inward=true;
  var player;
  const acc=3;
  var shrink=25;
  var shrinkBase=600;
  var shrinking=true;
  const turnrate=0.09;
  const maxSpeed=2;
  const friction = 0.008;
  var speed = 0;
  var speedlr=0;
   //65 left 68 right 87 up 83 down
   var array = {65: false, 68: false, 87: false, 83: false};    //event listener for resizing app to window size
   window.addEventListener('resize', function()
   {
     var width = window.innerWidth;
     var height = window.innerHeight;
     renderer.setSize(width, height);
     camera.aspect = width / height;
     camera.updateProjectionMatrix();
   });

  //event listener for resizing app to window size
  window.addEventListener('resize', function()
  {
    var width = window.innerWidth;
    var height = window.innerHeight;
    renderer.setSize(width, height);
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
  });


  // Orbit Control
  controls = new THREE.OrbitControls(camera,renderer.domElement);
  camera.lookAt(0,0,0);
    controls.maxDistance = 50;
    controls.minDistance = 50;
    controls.maxPolarAngle = Math.PI/3;
    controls.minPolarAngle = Math.PI/3;
    controls.rotateSpeed = 1;
    controls.enabled = false;
    camera.position.y = 50;
    camera.position.x = -40
    loader=new THREE.GLTFLoader();
loader.load(
        // resource URL
        // loader = new THREE.GLTFLoader();
        'models/goal/scene.gltf',
        // called when the resource is loaded
      function ( gltf ) {
          goal = gltf.scene;
          goal.scale.set(0.5,0.5,0.5);
          if (level == 1) {
            goal.position.set(2420, 10, 0);
          }
          if (level == 2) {
            goal.position.set(2320, 130, 0);
          }
          if (level == 3) {
            goal.position.set(1150, -215, 0);
          }
          scene.add( goal );
      },
        // called while loading is progressing
        function ( xhr ) {
            console.log( ( xhr.loaded / xhr.total * 100 ) + '% loaded' );
        },
        // called when loading has errors
        function ( error ) {
            console.log( 'An error happened' );
        });
  {
     loader = new THREE.CubeTextureLoader();
     texture = loader.load([
      'models/mountain/front.png',
      'models/mountain/back.png',
      'models/mountain/up.png',
      'models/mountain/down.png',
      'models/mountain/left.png',
      'models/mountain/right.png',

    ]);
    scene.background = texture;
    }
    if (level == 1) {
            level1GX();
          }
    if (level == 2) {
            level2GX();
          }
    if (level == 3) {
            level3GX();
          }


    function level1GX(){
    cube1Geometry = new THREE.CubeGeometry(1200, 10, 300);
    cube1Material = new THREE.MeshBasicMaterial( {color:'rgb(0,0,250)'} );
    cube1 = new THREE.Mesh( cube1Geometry, cube1Material );
    scene.add(cube1);

    cube2Geometry = new THREE.CubeGeometry(400, 10, 150);
    cube2Material = new THREE.MeshBasicMaterial( {color:'rgb(250,0,0)'} );
    cube2 = new THREE.Mesh( cube2Geometry, cube2Material );
    scene.add(cube2);

    cube3Geometry = new THREE.CubeGeometry(400, 10, 150);
    cube3Material = new THREE.MeshBasicMaterial( {color:'rgb(250,0,0)'} );
    cube3 = new THREE.Mesh( cube3Geometry, cube3Material );
    scene.add(cube3);

    cube4Geometry = new THREE.CubeGeometry(400, 10, 150);
    cube4Material = new THREE.MeshBasicMaterial( {color:'rgb(250,0,0)'} );
    cube4 = new THREE.Mesh( cube4Geometry, cube4Material );
    scene.add(cube4);

    cube5Geometry = new THREE.CubeGeometry(600, 10, 300);
    cube5Material = new THREE.MeshBasicMaterial( {color:'rgb(0,0,250)'} );
    cube5 = new THREE.Mesh( cube5Geometry, cube5Material );
    scene.add(cube5);
    }




    function level2GX(){
    cube1Geometry = new THREE.CubeGeometry(1200, 10, 300);
    cube1Material = new THREE.MeshBasicMaterial( {color:'rgb(0,0,250)'} );
    cube1 = new THREE.Mesh( cube1Geometry, cube1Material );
    scene.add(cube1);


    cube2Geometry = new THREE.CubeGeometry(200, 5, 300);
    cube2Material = new THREE.MeshBasicMaterial( {color:'rgb(120,0,250)'} );
    cube2 = new THREE.Mesh( cube2Geometry, cube2Material );
    scene.add(cube2);

    cube3Geometry = new THREE.CubeGeometry(400, 5, 300);
    cube3Material = new THREE.MeshBasicMaterial( {color:'rgb(120,122,250)'} );
    cube3 = new THREE.Mesh( cube3Geometry, cube3Material );
    scene.add(cube3);

    cube4Geometry = new THREE.CubeGeometry(400, 5, 30);
    cube4Material = new THREE.MeshBasicMaterial( {color:'rgb(0,122,100)'} );
    cube4 = new THREE.Mesh( cube4Geometry, cube4Material );
    scene.add(cube4);

    obst1Geometry = new THREE.CubeGeometry(4, 12, 50);
    obst1Material = new THREE.MeshBasicMaterial( {color:'rgb(250,73,0)'} );
    obst1 = new THREE.Mesh( obst1Geometry, obst1Material );
    scene.add(obst1);

    obst2Geometry = new THREE.CubeGeometry(4, 12, 50);
    obst2Material = new THREE.MeshBasicMaterial( {color:'rgb(0,0,111)'} );
    obst2 = new THREE.Mesh( obst2Geometry, obst2Material );
    scene.add(obst2);

    obst3Geometry = new THREE.CubeGeometry(200, 5, 160);
    obst3Material = new THREE.MeshBasicMaterial( {color:'rgb(250,73,111)'} );
    obst3 = new THREE.Mesh( obst3Geometry, obst3Material );
    scene.add(obst3);

    obst4Geometry = new THREE.CubeGeometry(4, 12, 130);
    obst4Material = new THREE.MeshBasicMaterial( {color:'rgb(124,0,0)'} );
    obst4 = new THREE.Mesh( obst4Geometry, obst4Material );
    scene.add(obst4);

    obst5Geometry = new THREE.CubeGeometry(200, 5, 160);
    obst5Material = new THREE.MeshBasicMaterial( {color:'rgb(11,73,111)'} );
    obst5 = new THREE.Mesh( obst5Geometry, obst5Material );
    scene.add(obst5);

    obst6Geometry = new THREE.CubeGeometry(4, 12, 130);
    obst6Material = new THREE.MeshBasicMaterial( {color:'rgb(0,10,0)'} );
    obst6= new THREE.Mesh( obst6Geometry, obst6Material );
    scene.add(obst6);
    }

    function level3GX(){
      cube1Geometry = new THREE.CubeGeometry(600, 10, 300);
    cube1Material = new THREE.MeshBasicMaterial( {color:'rgb(95,0,124)'} );
    cube1 = new THREE.Mesh( cube1Geometry, cube1Material );
    scene.add(cube1);

    cube2Geometry = new THREE.CubeGeometry(60, 10, 60);
    cube2Material = new THREE.MeshBasicMaterial( {color:'rgb(0,0,250)'} );
    cube2 = new THREE.Mesh( cube2Geometry, cube2Material );
    scene.add(cube2);

    cube3Geometry = new THREE.CubeGeometry(60, 10, 60);
    cube3Material = new THREE.MeshBasicMaterial( {color:'rgb(0,0,250)'} );
    cube3 = new THREE.Mesh( cube3Geometry, cube3Material );
    scene.add(cube3);

    cube4Geometry = new THREE.CubeGeometry(60, 10, 60);
    cube4Material = new THREE.MeshBasicMaterial( {color:'rgb(0,0,250)'} );
    cube4 = new THREE.Mesh( cube4Geometry, cube4Material );
    scene.add(cube4);

    cube5Geometry = new THREE.CubeGeometry(60, 10, 60);
    cube5Material = new THREE.MeshBasicMaterial( {color:'rgb(0,0,250)'} );
    cube5 = new THREE.Mesh( cube5Geometry, cube5Material );
    scene.add(cube5);

    cube6Geometry = new THREE.CubeGeometry(400, 5, 40);
    cube6Material = new THREE.MeshBasicMaterial( {color:'rgb(125,77,250)'} );
    cube6 = new THREE.Mesh( cube6Geometry, cube6Material );
    scene.add(cube6);

    cube7Geometry = new THREE.CubeGeometry(30,30,30);
    cube7Material = new THREE.MeshBasicMaterial( {color:'rgb(200,0,250)'} );
    cube7 = new THREE.Mesh( cube7Geometry, cube7Material );
    scene.add(cube7);

    cube8Geometry = new THREE.CubeGeometry(30,30,30);
    cube8Material = new THREE.MeshBasicMaterial( {color:'rgb(170,0,250)'} );
    cube8 = new THREE.Mesh( cube8Geometry, cube8Material );
    scene.add(cube8);
    }


    function level1Init(){

          ground1Shape = new CANNON.Box(new CANNON.Vec3(600,5,150));
          ground1Material = new CANNON.Material();
          Ccube1 = new CANNON.Body({
            mass:0,
            material:ground1Material
          });
          Ccube1.addShape(ground1Shape);
          Ccube1.position.x+=450;
          world.add(Ccube1);

          groundShape2 = new CANNON.Box(new CANNON.Vec3(200,5,75));
          ground2Material = new CANNON.Material();
          Ccube2 = new CANNON.Body({
            mass:0,
            material:ground2Material
          });
          Ccube2.addShape(groundShape2);
          Ccube2.position.x+=1250;
          Ccube2.position.z+=75;
          world.add(Ccube2);

          groundShape3 = new CANNON.Box(new CANNON.Vec3(200,5,75));
          ground3Material = new CANNON.Material();
          Ccube3 = new CANNON.Body({
            mass:0,
            material:ground2Material
          });
          Ccube3.addShape(groundShape2);
          Ccube3.position.x+=1550;
          Ccube3.position.z-=75;
          world.add(Ccube3);

          groundShape4 = new CANNON.Box(new CANNON.Vec3(200,5,75));
          ground4Material = new CANNON.Material();
          Ccube4 = new CANNON.Body({
            mass:0,
            material:ground4Material
          });
          Ccube4.addShape(groundShape4);
          Ccube4.position.x+=1850;
          Ccube4.position.z+=75;
          world.add(Ccube4);

          groundShape5 = new CANNON.Box(new CANNON.Vec3(300,5,150));
          ground5Material = new CANNON.Material();
          Ccube5 = new CANNON.Body({
            mass:0,
            material:ground5Material
          });
          Ccube5.addShape(groundShape5);
          Ccube5.position.x+=2350;
          world.add(Ccube5);
    }




    function level2Init(){
     ground1Shape = new CANNON.Box(new CANNON.Vec3(600,5,150));
          ground1Material = new CANNON.Material();
          Ccube1 = new CANNON.Body({
            mass:0,
            material:ground1Material
          });
          Ccube1.addShape(ground1Shape);
          Ccube1.position.x+=450;
          world.add(Ccube1);

          ground2Shape = new CANNON.Box(new CANNON.Vec3(100,2.5,150));
          ground2Material = new CANNON.Material();
          Ccube2 = new CANNON.Body({
            mass:0,
            material:ground2Material
          });
          Ccube2.addShape(ground2Shape);
          Ccube2.position.x+=1100;
          cube2.rotateZ(Math.PI/4);
          Ccube2.position.y+=75;
          world.add(Ccube2);

          ground3Shape = new CANNON.Box(new CANNON.Vec3(200,2.5,150));
          ground3Material = new CANNON.Material();
          Ccube3 = new CANNON.Body({
            mass:0,
            material:ground3Material
          });
          Ccube3.addShape(ground3Shape);
          Ccube3.position.x+=1370;
          Ccube3.position.y+=145;
          world.add(Ccube3);

          ground4Shape = new CANNON.Box(new CANNON.Vec3(200,2.5,15));
          ground4Material = new CANNON.Material();
          Ccube4 = new CANNON.Body({
            mass:0,
            material:ground4Material
          });
          Ccube4.addShape(ground4Shape);
          Ccube4.position.x+=1770;
          Ccube4.position.y+=145;
          world.add(Ccube4);

          obst1Shape = new CANNON.Box(new CANNON.Vec3(2,6,25));
          Cobst1Material = new CANNON.Material();
          Cobst1 = new CANNON.Body({
            mass:0,
            material:Cobst1Material
          });
          Cobst1.addShape(obst1Shape);
          Cobst1.position.x+=1700;
          Cobst1.position.y+=155;;
          world.add(Cobst1);

          obst2Shape = new CANNON.Box(new CANNON.Vec3(2,6,25));
          Cobst2Material = new CANNON.Material();
          Cobst2 = new CANNON.Body({
            mass:0,
            material:Cobst2Material
          });
          Cobst2.addShape(obst2Shape);
          Cobst2.position.x+=1850;
          Cobst2.position.y+=155;
          world.add(Cobst2);

          obst3Shape = new CANNON.Box(new CANNON.Vec3(100,2.5,80));
          Cobst3Material = new CANNON.Material();
          Cobst3 = new CANNON.Body({
            mass:0,
            material:Cobst3Material
          });
          Cobst3.addShape(obst3Shape);
          Cobst3.position.x+=2090;
          Cobst3.position.y+=135;
          world.add(Cobst3);

          obst4Shape = new CANNON.Box(new CANNON.Vec3(2,6,65));
          Cobst4Material = new CANNON.Material();
          Cobst4 = new CANNON.Body({
            mass:0,
            material:Cobst4Material
          });
          Cobst4.addShape(obst4Shape);
          Cobst4.position.x+=2090;
          Cobst4.position.y+=140;
          world.add(Cobst4);

          obst5Shape = new CANNON.Box(new CANNON.Vec3(100,2.5,80));
          Cobst5Material = new CANNON.Material();
          Cobst5 = new CANNON.Body({
            mass:0,
            material:Cobst5Material
          });
          Cobst5.addShape(obst5Shape);
          Cobst5.position.x+=2340;
          Cobst5.position.y+=135;
          world.add(Cobst5);

          obst6Shape = new CANNON.Box(new CANNON.Vec3(2,6,65));
          Cobst6Material = new CANNON.Material();
          Cobst6 = new CANNON.Body({
            mass:0,
            material:Cobst6Material
          });
          Cobst6.addShape(obst6Shape);
          Cobst6.position.x+=2340;
          Cobst6.position.y+=140;
          world.add(Cobst6);

          if(rotating)
          {
            obst1.rotateY(1.6);
          }

          if(rotating)
          {
            obst2.rotateY(1.6);
          }

          if(rotating)
          {
            obst4.rotateY(1.6);
          }
          if(rotating)
          {
            obst6.rotateY(1.6);
          }
    }


    function level3Init(){
     ground1Shape = new CANNON.Box(new CANNON.Vec3(300,5,150));
          ground1Material = new CANNON.Material();
          Ccube1 = new CANNON.Body({
            mass:0,
            material:ground1Material
          });
          Ccube1.addShape(ground1Shape);
          Ccube1.position.x+=50;
          world.add(Ccube1);

          ground2Shape = new CANNON.Box(new CANNON.Vec3(30,5,30));
          ground2Material = new CANNON.Material();
          Ccube2 = new CANNON.Body({
            mass:0,
            material:ground2Material
          });
          Ccube2.addShape(ground2Shape);
          Ccube2.position.x+=425;
          Ccube2.position.y-=30;
          world.add(Ccube2);

          ground3Shape = new CANNON.Box(new CANNON.Vec3(30,5,30));
          ground3Material = new CANNON.Material();
          Ccube3 = new CANNON.Body({
            mass:0,
            material:ground3Material
          });
          Ccube3.addShape(ground3Shape);
          Ccube3.position.x+=510;
          Ccube3.position.y-=80;
          Ccube3.position.z-=60;
          world.add(Ccube3);

          ground4Shape = new CANNON.Box(new CANNON.Vec3(30,5,30));
          ground4Material = new CANNON.Material();
          Ccube4 = new CANNON.Body({
            mass:0,
            material:ground4Material
          });
          Ccube4.addShape(ground4Shape);
          Ccube4.position.x+=595;
          Ccube4.position.y-=130;
          Ccube4.position.z+=40;
          world.add(Ccube4);

          ground5Shape = new CANNON.Box(new CANNON.Vec3(30,5,30));
          ground5Material = new CANNON.Material();
          Ccube5 = new CANNON.Body({
            mass:0,
            material:ground5Material
          });
          Ccube5.addShape(ground5Shape);
          Ccube5.position.x+=680;
          Ccube5.position.y-=180;
          Ccube5.position.z-=10;
          world.add(Ccube5);

          ground6Shape = new CANNON.Box(new CANNON.Vec3(200,2.5,20));
          ground6Material = new CANNON.Material();
          Ccube6 = new CANNON.Body({
            mass:0,
            material:ground6Material
          });
          Ccube6.addShape(ground6Shape);
          Ccube6.position.x+=1000;
          Ccube6.position.y-=220;
          world.add(Ccube6);

          ground7Shape = new CANNON.Box(new CANNON.Vec3(15, 15, 15));
          ground7Material = new CANNON.Material();
          Cobst1 = new CANNON.Body({
            mass:0,
            material:ground7Material
          });
          Cobst1.addShape(ground7Shape);
          Cobst1.position.x+=1000;
          Cobst1.position.y-=200;
          Cobst1.position.z+=70;
          world.add(Cobst1);

          ground8Shape = new CANNON.Box(new CANNON.Vec3(15, 15, 15));
          ground8Material = new CANNON.Material();
          Cobst2 = new CANNON.Body({
            mass:0,
            material:ground8Material
          });
          Cobst2.addShape(ground8Shape);
          Cobst2.position.x+=1050;
          Cobst2.position.y-=200;
          Cobst2.position.z-=70;
          world.add(Cobst2);
    }


    function level1Update(){
      cube1.position.copy(Ccube1.position);
      cube1.quaternion.copy(Ccube1.quaternion);

      cube2.position.copy(Ccube2.position);
      cube2.quaternion.copy(Ccube2.quaternion);

      cube3.position.copy(Ccube3.position);
      cube3.quaternion.copy(Ccube3.quaternion);

      cube4.position.copy(Ccube4.position);
      cube4.quaternion.copy(Ccube4.quaternion);

      cube5.position.copy(Ccube5.position);
      cube5.quaternion.copy(Ccube5.quaternion);
    }





    function level2Update(){
           cube1.position.copy(Ccube1.position);
           cube1.quaternion.copy(Ccube1.quaternion);

           cube2.position.copy(Ccube2.position);
           Ccube2.quaternion.copy(cube2.quaternion);

           cube3.position.copy(Ccube3.position);
           cube3.quaternion.copy(Ccube3.quaternion);

           cube4.position.copy(Ccube4.position);
           cube4.quaternion.copy(Ccube4.quaternion);

           obst1.position.copy(Cobst1.position);
           Cobst1.quaternion.copy(obst1.quaternion);

           obst2.position.copy(Cobst2.position);
           Cobst2.quaternion.copy(obst2.quaternion);

           obst3.position.copy(Cobst3.position);
           Cobst3.quaternion.copy(obst3.quaternion);

           obst4.position.copy(Cobst4.position);
           Cobst4.quaternion.copy(obst4.quaternion);

           obst5.position.copy(Cobst5.position);
           Cobst5.quaternion.copy(obst5.quaternion);

           obst6.position.copy(Cobst6.position);
           Cobst6.quaternion.copy(obst6.quaternion);

             if(inward)
     {
          Cobst1.position.z-=2;
           Cobst2.position.z+=2;

            Cobst4.position.z+=2;
           Cobst6.position.z-=2;

  }
  else {
    Cobst1.position.z+=2;
    Cobst2.position.z-=2;
    Cobst4.position.z-=2;
    Cobst6.position.z+=2;
  }
  if(Cobst2.position.z==70 && Cobst1.position.z==-70)
  {
    inward=false;
  }
  if(Cobst1.position.z==70 && Cobst2.position.z==-70)
  {
    inward=true;
  }
    }

  function level3Update(){
    cube1.position.copy(Ccube1.position);
          cube1.quaternion.copy(Ccube1.quaternion);

          cube2.position.copy(Ccube2.position);
          cube2.quaternion.copy(Ccube2.quaternion);

          cube3.position.copy(Ccube3.position);
          cube3.quaternion.copy(Ccube3.quaternion);

          cube4.position.copy(Ccube4.position);
          cube4.quaternion.copy(Ccube4.quaternion);

          cube5.position.copy(Ccube5.position);
          cube5.quaternion.copy(Ccube5.quaternion);

          cube6.position.copy(Ccube6.position);
          cube6.quaternion.copy(Ccube6.quaternion);

          cube7.position.copy(Cobst1.position);
          cube7.quaternion.copy(Cobst1.quaternion);

          cube8.position.copy(Cobst2.position);
          Cobst2.quaternion.copy(cube8.quaternion);

          if(inward)
       {
          Cobst1.position.z-=2;
             Cobst2.position.z+=2;

   }
   else {
     Cobst1.position.z+=2;
      Cobst2.position.z-=2;
      }
    if(Cobst2.position.z==70 && Cobst1.position.z==-70)
    {
      inward=false;
      }
    if(Cobst1.position.z==70 && Cobst2.position.z==-70)
      {
      inward=true;
    }
  }

    spheregeometry = new THREE.SphereGeometry( 5, 32, 32 );
    spherematerial = new THREE.MeshBasicMaterial( {color: 0x00ff00} );
    sphere = new THREE.Mesh( spheregeometry, spherematerial );



   scene.add( sphere );

   function initCannon() {

          world = new CANNON.World();
          world.gravity.set(0,-200,0);
          world.broadphase = new CANNON.NaiveBroadphase();


          sphereShape = new CANNON.Sphere(5);
          mass = 1;
          sphereBody = new CANNON.Body({
            mass: 1
          });
          sphereBody.addShape(sphereShape);
          sphereBody.position.y=10;
          sphereBody.linearDamping = 0.5;
          world.addBody(sphereBody);
          player=sphereBody;
          player.addEventListener("collide", function(e){ canJump=true; } );
          if (level == 1) {
            level1Init();
          }
          if (level == 2) {
            level2Init();
          }
          if (level == 3) {
            level3Init();
          }

      }




  //draw scene
  function updatePhysics() {

          // Step the physics world
          world.step(timeStep);
          // Copy coordinates from Cannon.js to Three.js
          sphere.position.copy(sphereBody.position);
          sphereBody.quaternion.copy(sphere.quaternion);
          if (level == 1) {
            level1Update();
          }
          if (level == 2) {
            level2Update();
          }
          if (level == 3) {
            level3Update();
          }


      }
var canJump = true;
window.addEventListener ("keydown",event=>{
  if(event.keyCode in array)
      array[event.keyCode] = true;
   if(event.keyCode == 32 && canJump)
    {
      sphereBody.velocity.y+=70;
      canJump = false;
    }
});


window.addEventListener ("keyup",event=>{
  if(event.keyCode in array)
    array[event.keyCode] = false;
});

var gameover = false;
var GameOver = function(x){
  gameover = true;
  if(x==1)
   {
     document.getElementById('refresh').style.display = 'block';
   }
  else if(x==2)
    {
      document.getElementById('win').style.display = 'block';
    }
}
var winner = function(){
  if (level == 1) {
     if( player.position.x < 2420 && player.position.x > 2410)
  {
    return true;
  }
  else {
    return false;
  }
  }
  if (level == 2) {
     if( player.position.x < 2320 && player.position.x > 2310)
  {
    return true;
  }
  else {
    return false;
  }
  }
  if (level == 3) {
     if( player.position.x < 1150 && player.position.x > 1140 && player.position.y > -215)
  {
    return true;
  }
  else {
    return false;
  }
  }

}
var accelerate = function(x){
  if(speed>=maxSpeed || speed<=-maxSpeed){
    return;
  }
  if(x==1)
  {
    speed+=acc;
  }
  else
  {
    speed-=acc;
  }
}
// small letters dont stop
var quat = new THREE.Quaternion();
var playerMovement = function(){
  var inputVelocity = new THREE.Vector3();
  inputVelocity.set(0,0,0);
  //65 left 68 right 87 up 83 down
  if(array[87]){
        //Forward
        // accelerate(1);
        inputVelocity.x += acc;
    }
  if(array[83]){
        //Back
        // accelerate(2);
        inputVelocity.x -= acc;
    }
  if(array[65]){
        //left
        // player.rotateY(turnrate);
        inputVelocity.z -= acc;

    }
  if(array[68]){
        //right
        // player.rotateY(-turnrate);
        inputVelocity.z += acc;
    }

  quat.setFromEuler(new THREE.Euler(sphere.rotation.x,sphere.rotation.y,0));
  // quat.multiplyVector3(inputVelocity);
  inputVelocity.applyQuaternion(quat);
  player.velocity.x += inputVelocity.x;
  player.velocity.z += inputVelocity.z;
  controls.target.set(sphere.position.x,sphere.position.y,sphere.position.z);
  controls.update();
}

var decelerate = function(){
  if(speed>0)
    {
      speed-=friction;
    }
    else if(speed<0)
    {
      speed+=friction;
    }
}

  var render = function()
  {
    renderer.render(scene, camera);
  };
  var loseheight = 0;
  if (level == 3) {
     loseheight = -220;
    }

  var GameLoop = function()
  {
    console.log(sphereBody.position.y);
    console.log(sphereBody.position.x);
    if(sphereBody.position.y<loseheight)
    {
      GameOver(1);
    }
    if(winner())
        {
          GameOver(2);
        }
    requestAnimationFrame(GameLoop);
    playerMovement();
    updatePhysics();
    render();

  }
  initCannon();

  GameLoop();
</script>
  </body>
</html>
