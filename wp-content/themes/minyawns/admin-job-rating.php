<style>
    .txt-link{
        text-decoration: none;
        display: inline-block;
        width: 448px;
    }
    .btn-rate{
        background: #ccc;
        border: 0px;
        padding: 4px 18px;
        color: #000;
        border-radius: 7px;
        
    }
    .divbox{
        width: 578px;
        border: 1px solid #ccc;
        
        margin: 15px auto;
        
        
    }
    .insidebox{
    padding: 30px;
    }
    h3{
        padding: 7px;
        
    }
    </style>
    <div class="divbox">
        <h3>These Minions haven't received ratings yet, please rate them.</h3>
        <hr>
        <div class="insidebox">
<?php
global $wpdb;

$sql = $wpdb->prepare("SELECT $wpdb->posts.post_title,$wpdb->posts.post_name,$wpdb->posts.ID
FROM {$wpdb->prefix}userjobs, $wpdb->posts
WHERE {$wpdb->prefix}userjobs.job_id = $wpdb->posts.ID
AND {$wpdb->prefix}userjobs.rating =0 AND $wpdb->posts.post_type='job' AND $wpdb->posts.post_status = 'publish'
GROUP BY my_userjobs.job_id");



$results=$wpdb->get_results($sql);

        foreach($results as $result)
{
?>
<a class="txt-link" href="#" target="_blank"><?php echo $result->post_name ?></a><a href="<?php echo site_url() ?>/job/<?php echo $result->post_name ?>" target="_blank"><button class="btn btn-rate"> Rate</button></a><br><hr>
<?php     
}
        
        ?>   </div>
    </div>