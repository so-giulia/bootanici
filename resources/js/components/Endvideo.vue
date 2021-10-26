
<template>
      <video ref="videoRef" width="100%" height="100%" loop autoplay muted>
        <!-- <source src="../../../public/video/endvideo.mp4" type="video/mp4"> -->
        <source src="http://127.0.0.1:8000/storage/public/videos/endvideo.mp4" type="video/mp4">
        
        Your browser does not support the video tag.
      </video>
</template>

<script>
  // custom skin css
  // import '../src/custom-theme.css'
  
  export default {
    name:"Endvideo",
    data() {
      return {
       
      }
    },
    mounted() {
      // console.log('this is current player instance object', this.player)
       this.$refs.videoRef.play();
       console.log(this.$refs);
    }
  };
    
  
</script>

  