<?php 

$file 	= './dbc_config/config.xml';

$xmlstr = file_get_contents($file);

$xml 	= simplexml_load_string($xmlstr);

$config	= $xml->xpath('//config');	

$current_version = $config[0]->version;

$current_version = explode('.',$current_version);



?>
<?php $curr_lang = get_current_lang(); ?>





    <div class="row">

      <div class="col-md-12">

        <div class="row">

          <div class="col-md-6">

            <div class="tile tile-orange">

              <div class="img">

                <i class="fa fa-users"></i>

              </div>

              <div class="content">

                <p class="big">

                  <?php 
                  $CI = get_instance();
                  $CI->load->database();
                  $query = $CI->db->get_where('users',array('status'=>1));
                  echo $query->num_rows();
                  ?>

                </p>

                <p class="title">

                  <?php echo lang_key_admin('users') ?>

                </p>

              </div>

            </div>

          </div>

          <div class="col-md-6">

            <div class="tile tile-dark-blue">

              <div class="img">

                <i class="fa fa-bars"></i>

              </div>

              <div class="content">
                <p class="big">
                  <?php
                  $query = $CI->db->get_where('videos',array('status'=>1));
                  echo $query->num_rows();
                  ?>
                </p>
                <p class="title">
                  <?php echo lang_key_admin('videos');?>
                </p>
              </div>
            </div>
          </div>

          
        </div>
      </div>
    </div>


   
<style type="text/css">
  .version{
    font-size: 14px;
    font-style: italic;
    margin:10px 0 0 44px;
  }
</style>
