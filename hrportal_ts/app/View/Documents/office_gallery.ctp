<div id="page_content">
    <div id="page_content_inner">

        <div class="gallery_grid uk-grid-width-medium-1-4 uk-grid-width-large-1-5" data-uk-grid="{gutter: 16}">
		<?php foreach($Documentlist as $catgallery){
       
		?>
             <div>
                    <div class="md-card md-card-hover">
                        <div class="gallery_grid_item md-card-content">
                            <a href="<?php echo $this->webroot.'uploads/document/'.$catgallery['Documentlists']['file'];?>" data-uk-lightbox="{group:'gallery'}">
                                <img src="<?php echo $this->webroot.'uploads/document/'.$catgallery['Documentlists']['file'];?>" alt="">
                            </a>
                            <div class="gallery_grid_image_caption">
                                
                                <span class="gallery_image_title uk-text-truncate"><?php echo $catgallery['Documentlists']['document_desc']?></span>
                                <span class="uk-text-muted uk-text-small"><?php echo $catgallery['Documentlists']['created_date']?></span>
                            </div>
                        </div>
                    </div>
                </div>
                     <?php } ?>          
                            
                  </div>
         </div>
         </div>
<div class="uk-width-large-1-1">
    <div id="modal_overflow_response" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-small">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>
    
    
    
   
