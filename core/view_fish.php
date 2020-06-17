<div class="container">
    <div class="span3 well">
        <center>
        <a href="#aboutModal" data-toggle="modal" data-target="#myModal"><img src="<?php echo $result['photo_url']; ?>" name="aboutme" width="140" height="140" class="img-circle"></a>
        <h3><?php echo $result['title']; ?></h3>
        <em>Натисни на снимката за повече информация</em>
		</center>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" id="myModalLabel">Информация</h4>
                    </div>
                <div class="modal-body">
                    <center>
                    <img src="<?php echo $result['photo_url']; ?>" name="aboutme" width="140" height="140" border="0" class="img-circle"></a>
                    <h3 class="media-heading"><?php echo $result['title']; ?></h3>
                    <span><strong>Категория: </strong></span>
                        <span class="label <?php if($result['cat_id'] == '1') { echo 'label-info'; } elseif ($result['cat_id'] == '2') { echo 'label-success'; } ?>"><?php echo $result['cat_name']; ?></span>
                    </center>
                    <hr>
                    <center><p class="text-left"><strong>Описание: </strong><br><?php echo $result['description']; ?></p><br></center>
					<hr>
                    <center><p class="text-left"><strong>Цена: </strong><?php echo $result['price']; ?>лв.</p><br></center>
                </div>
                <div class="modal-footer">
                    <center>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Затвори</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<br /><br />