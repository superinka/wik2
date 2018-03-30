<div class="blog-item">
          <div class="row">
            <div class="col-lg-2 col-sm-2">
              <div class="date-wrap">
                <span class="date">
                  <?php
                  $date = date_create($value->Publish_Date)->format('d');
                  echo $date;
                  ?>
                </span>
                <span class="month">
                <?php echo 'Tháng'.' '. $value->Publish_month ?>
                </span>
              </div>

            </div>
            <div class="col-lg-10 col-sm-10">
              <div class="blog-img">
                <img src="img/blog/img7.jpg" alt=""/>
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-lg-2 col-sm-2 text-right">
              <div class="author">
                Viết bởi
                <a href="#">
                  <?php echo $user_name ?>
                </a>
              </div>
              <ul class="list-unstyled">
                <li>
                  <a href="javascript:;">
                    <em>
                      <?php echo $category_name ?>
                    </em>
                  </a>
                </li>
              </ul>
              <div class="st-view">
                <ul class="list-unstyled">
                  <li>
                    <a href="javascript:;">
                      <?php echo $value->Num_Views ?> Lượt xem
                    </a>
                  </li>
                  <li>
                    <a href="javascript:;">
                      15 Bình Luận
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-10 col-sm-10">
              <h1>
                <a href="<?php echo base_url('site/blog/detail/'.$value->Post_ID) ?>">
                  <?php echo $value->Post_Name ?>.
                </a>
              </h1>
              <p>
                <?php 
                
                if($value->description == null) {echo 'Không có miêu tả';}
                else {echo $value->description;}
                ?>
              </p>
              <a href="<?php echo base_url('site/blog/detail/'.$value->Post_ID) ?>" class="btn btn-primary">
                Đọc Tiếp
              </a>
            </div>
          </div>
        </div>