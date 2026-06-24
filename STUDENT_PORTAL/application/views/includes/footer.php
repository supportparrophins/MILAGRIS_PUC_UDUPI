<?php if($_SESSION['loggedIn_type']!='Mobile'){ ?>

          <footer id="footer" class="main-footer d-flex px-3 bg-white border-top">

            <span class="copyright ml-auto my-auto mr-2">Copyright © <script>document.write(new Date().getFullYear())</script>-<?php echo date('y', strtotime('+1 year')); ?>

              <a href="" target="_blank" rel="nofollow"><span class="title_green">School</span><span class="title_blue">Phins</span>.</a> All rights reserved

            </span>

          </footer>
<?php } ?>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

    <script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/dist/scripts/extras.1.0.0.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/dist/scripts/shards-dashboards.1.0.0.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/dist/scripts/app/app-blog-overview.1.0.0.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/js/forgotPassword.js" type="text/javascript"></script>

    <script type="text/javascript">

        var windowURL = window.location.href;

        pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));

        var x= $('a[href="'+pageURL+'"]');

            x.addClass('active');

            x.parent().addClass('active');

        var y= $('a[href="'+windowURL+'"]');

            y.addClass('active');

            y.parent().addClass('active');



            $(function() {

            $(this).bind("contextmenu", function(e) {

                e.preventDefault();

            });

        }); 

    </script>

    

  </body>

</html>

