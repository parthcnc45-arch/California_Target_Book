<?php

    global $cached;
    $incumbent = retrieve_info($old_fourcode);
    $img_src = $incumbent['IMG']?$incumbent['IMG']:url('assets/imgs/avatar.png');
    $cand_id = $incumbent['CAND_ID']??null;

    $social = retrieve_social_media($cand_id);
    $fb = $social['facebook'] ?? '';
    $tw = $social['twitter'] ?? '';



?>

<div class="row ctb-incumbentBox">
    <div class="col-md-12 px-0">

        <div class="ctb-incumbent-img">
            <div class="ctb-incumbent-banner-img">
                <img src="<?php echo url('assets/imgs/flag-bg.png') ?>" alt="banner" class="img-fluid" />
            </div>
        </div>
    </div>
    <div class="col-md-12 ctb-incumbentBox-content">
        <div class="d-flex align-items-end justify-content-between px-5 ctb-incumbentBox-avatar">
            <div class="ctb-incumbent-profile-img text-center">
                <img src="<?= $img_src ?>" alt="profile" class="img-fluid"  />
            </div>
            <div>
                <?php if ($fb){ ?>
                    <a href="https://www.facebook.com/<?= $fb ?>" target="_blank" class="ctb-facebook-btn text-decoration-none" >
                        <img src="<?php echo  url('assets/imgs/facebook.png') ?>" alt="fb" />Follow
                    </a>
                <?php }if ($tw) {?>
                    <a href="https://twitter.com/<?= $tw ?>" target="_blank" class="ctb-twitter-btn text-decoration-none">
                        <img src="<?php echo url('assets/imgs/twitter.png')?>" alt="twitter" />Follow
                    </a>
                <?php }?>
            </div>
        </div>
        <div>
            <h2><?= $incumbent['INCUMBENT']??'' ?> (<?= $incumbent['PARTY']??'' ?>)</h2>
            <span>Born: <?= $incumbent['DOB'] ?? '' ?> | Term <?=  $incumbent['TERM_LIMIT'] ?? ''  ?></span>
            <p><?=  $incumbent['BIO'] ?? ''  ?></p>
        </div>
    </div>
</div>


<?php
    function retrieve_info($fourcode)
    {
        $conn = Util::get_ctb_conn();
        $id='';
        $retval=[];

        global $cand_id;
        $sql = "SELECT * FROM ctb2016_e22_incumbent WHERE DIST = '$fourcode'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['CAND_ID'];
                $cand_id = $id;
                $retval['PARTY'] = $row['PARTY'];
                $retval['INCUMBENT'] = $row['LEGISLATOR'];
                $retval['DOB'] = $row['DOB'];
                $retval['TERM_LIMIT'] = $row['TERM_LIMIT'];
                $retval['CAND_ID'] = $row['CAND_ID'];
            }
        }

        $types = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
        $retval['IMG'] = '';
        foreach ($types as $type) {
            $tmp_file = "img/candidates/" . $id . $type;
            if (file_exists($tmp_file)) {
                $retval['IMG'] = '/img/candidates/' . $id . $type;
                break;
            }
        }


        $sql = "SELECT text from ctb_cand_bios WHERE cand_id = '$id' ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['BIO'] = $row['text'];
            }
        }
        return $retval;
    }

    function retrieve_social_media($cand_id)
    {
        $conn = Util::get_ctb_conn();
        $retval=[];
        $sql = "SELECT * from ctb_cand_links WHERE cand_id = '$cand_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
            }
        }

        return $retval;
    }
?>
