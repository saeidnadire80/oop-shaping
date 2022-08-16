<script>
  alert('به سایت فروشگاهی کوروش خوش آمدید.');
  let time =document.getElementById('time');
  function date(){
    let date= new Date();
    time.innerText=date.toLocaleTimeString();
  }
  setInterval(date,1000);
</script>