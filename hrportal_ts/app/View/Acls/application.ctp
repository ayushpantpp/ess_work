

<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
              Application, Roles, Permissions
            </li>
            <li>
              Manage
            </li>            
        </ul>
    </div>
</div>

<h2 class="demoheaders">Manage : Application, Roles, Permissions</h2>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td></td>
        <td align="right"><h3>Controllers And Actions</h3></td>
        <td align="right">
            
            <input type ="text" value="" name ="searchcon" id="controllersearch" style="width:160px">
            <input type ="text" value="" name ="searchview" id="viewsearch" style="width:160px">
        </td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td valign="top" style="background-color: #d0f0c0;padding: 10px;" width="26%">
            <div class="acls-application-cus">
                <b>Application</b>
                <?php echo $this->form->create('Applications', array('id' => 'Applications')); ?>
                <?php echo $this->form->input('Applications.vc_application_name', array('type' => 'text', 'label' => false)); ?>
                <?php echo $this->form->button('Create', array('name' => 'Applications.create', 'type' => 'button','class' => 'successButton')); ?>
                <?php //echo $this->form->button('Edit', array('name' => 'Applications.edit', 'type' => 'button')); ?>
                <?php echo $this->form->button('Delete', array('name' => 'Applications.delete', 'type' => 'button','class' => 'infoButton')); ?>
                <?php echo $this->form->end(); ?>
            </div>
            <div class="acls-application-cus">
                <b>Roles</b>
                <?php echo $this->form->create('Roles', array('id' => 'Roles')); ?>
                <?php echo $this->form->input('Roles.vc_role_name', array('type' => 'text', 'label' => false)); ?>
                <?php echo $this->form->button('Create', array('name' => 'Roles.create', 'type' => 'button','class' => 'successButton')); ?>
                <?php //echo $this->form->button('Edit', array('name' => 'Roles.edit', 'type' => 'button')); ?>
                <?php echo $this->form->button('Delete', array('name' => 'Roles.delete', 'type' => 'button','class' => 'infoButton')); ?>
                <?php echo $this->form->end(); ?>
            </div>
            <div class="acls-application-cus">
                <b>Permissions</b>
                <?php echo $this->form->create('Permissions', array('id' => 'Permissions')); ?>
                <?php echo $this->form->input('Permissions.vc_permission_name', array('type' => 'text', 'class' => 'drop select2', 'label' => false)); ?>
                <?php echo $this->form->button('Create', array('name' => 'PermissionsCreate', 'type' => 'button','class' => 'successButton')); ?>
                <?php //echo $this->form->button('Edit', array('name' => 'PermissionsEdit', 'type' => 'button')); ?>
                <?php echo $this->form->button('Delete', array('name' => 'PermissionsDelete', 'type' => 'button','class' => 'infoButton')); ?>
                <?php echo $this->form->end(); ?>
            </div>            
        </td>
        <td valign="top">
            <div id="tree" style="width:320px; float:none; height:300px; overflow:auto; border:1px solid gray;background-color: white; margin-left:15px;"></div>
            <div style="line-height: 40px; height: 80px;text-align: center;background-color: #d0f0c0; margin-left:15px;">
                <?php echo $this->form->button('Enable Permission', array('id' => 'PermissionsEnable', 'name' => 'PermissionsEnable', 'type' => 'button','class' => 'infoButton')); ?>
                <?php echo $this->form->button('Disable Permission', array('id' => 'PermissionsDisable', 'name' => 'PermissionsDisable', 'type' => 'button','class' => 'infoButton')); ?>
            </div>
        </td>
       
        <td  valign="top">
            
            <div id="catree" class="acl-control-nd-action"></div>
            <?php //echo $form->input('action_name', array('size' => '10', 'type' => 'select', 'class' => 'drop select2', 'label' => false)); ?>    
            <div class="acl-control-nd-action-buttons" style="line-height: 40px; height: 70px;text-align: center;background-color: #d0f0c0; margin-left:15px;">
                <?php echo $this->form->button('Allow', array('id' => 'ControllerActionAllow', 'name' => 'ControllerActionAllow', 'type' => 'button','class' => 'infoButton')); ?>
                <?php echo $this->form->button('Deny', array('id' => 'ControllerActionDeny', 'name' => 'ControllerActionDeny', 'type' => 'button','class' => 'infoButton')); ?>
                <?php echo $this->form->button('Release', array('id' => 'ControllerActionRelease', 'name' => 'ControllerActionRelease', 'type' => 'button','class' => 'infoButton')); ?>                                
            </div>
        </td>
    </tr>
</table>
<script type="text/javascript">
    $(function(){
        jQuery.xhrPool = [];
        jQuery("#catree").jstree({
            "plugins" : [ "themes", "json_data", "ui", "crrm", "dnd", "search", "types", "contextmenu" ],
            "json_data" : { "ajax" :    {
                    "url" : "<?php echo $this->webroot . 'acls/pr_controlleractiontreelist_json'; ?>",
                    "data" : function (n) {return n;},
                    beforeSend: function(jqXHR) { 
                        jQuery.each(jQuery.xhrPool, function(index, jqXHR1) { //alert(index);alert(jqXHR1);
                                jqXHR1.abort();
                        });
                        jQuery.xhrPool.push(jqXHR);
                    }
                }
            },
            "core":{"animation":"0"},
            // Using types - most of the time this is an overkill
            // read the docs carefully to decide whether you need types
            "types" : {
                // I set both options to -2, as I do not need depth and children count checking
                // Those two checks may slow jstree a lot, so use only when needed
                "max_depth" : -2,
                "max_children" : -2,
                // I want only `drive` nodes to be root nodes 
                // This will prevent moving or creating any other type as a root node
                "valid_children" : [ "drive" ],
                "types" : {
                    // The default type
                    "default" : {
                        // I want this type to have no children (so only leaf nodes)
                        // In my case - those are files
                        "valid_children" : "none",
                        // If we specify an icon for the default type it WILL OVERRIDE the theme icons
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/file.png"
                        }
                    },
                    // The `folder` type
                    "controller_enabled" : {
                        // can have files and other folders inside of it, but NOT `drive` nodes
                        "valid_children" : [ "default", "action" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/controller_e.png"
                        }
                    },
                    // The `drive` nodes 
                    "action_enabled" : {
                        // can have files and folders inside, but NOT other `drive` nodes
                        "valid_children" : [ "default" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/action_e.png"
                        }
                    },
                    // The `folder` type
                    "controller_notspecified" : {
                        // can have files and other folders inside of it, but NOT `drive` nodes
                        "valid_children" : [ "default", "action" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/controller_n.png"
                        }
                    },
                    // The `drive` nodes 
                    "action_notspecified" : {
                        // can have files and folders inside, but NOT other `drive` nodes
                        "valid_children" : [ "default" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/action_n.png"
                        }
                    },                    
                    // The `folder` type
                    "controller_disabled" : {
                        // can have files and other folders inside of it, but NOT `drive` nodes
                        "valid_children" : [ "default", "action" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/controller_d.png"
                        }
                    },
                    // The `drive` nodes 
                    "action_disabled" : {
                        // can have files and folders inside, but NOT other `drive` nodes
                        "valid_children" : [ "default" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/action_d.png"
                        }
                    },
                    // The `folder` type
                    "controller_locked" : {
                        // can have files and other folders inside of it, but NOT `drive` nodes
                        "valid_children" : [ "default", "action" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/controller_l.png"
                        }
                    },
                    // The `drive` nodes 
                    "action_locked" : {
                        // can have files and folders inside, but NOT other `drive` nodes
                        "valid_children" : [ "default" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/action_l.png"
                        }
                    }
                }
            }            
        })
        .bind("loaded.jstree", function (event, data) {
            $.jstree._reference('#catree').open_all();
        })
        .bind("refresh.jstree", function (event, data) {
            $.jstree._reference('#catree').open_all();
        })         
        .bind("select_node.jstree", function(e, data) {
            data.rslt.obj.each(function () {
                //alert($(this).attr("rel").replace("node_",""));
                //$("#p_res_view").html('resource -> '+$.jstree._reference('#tree').get_path(this).toString().replace(/,/g, '/'));
                //viewPrivilege();
            });
        });
        jQuery("#tree").jstree({
            "plugins" : [ "themes", "json_data", "ui", "crrm", "dnd", "search", "types", "contextmenu" ],
            "json_data" : { "ajax" :    {
                    "url" : "<?php echo $this->webroot . 'applications/pr_arptreelist_json'; ?>",
                    "data" : function (n) {return n;}
                }
            },
            "core":{"animation":"0","initially_open" : [ "0" ]},
            // Using types - most of the time this is an overkill
            // read the docs carefully to decide whether you need types
            "types" : {
                // I set both options to -2, as I do not need depth and children count checking
                // Those two checks may slow jstree a lot, so use only when needed
                "max_depth" : -2,
                "max_children" : -2,
                // I want only `drive` nodes to be root nodes 
                // This will prevent moving or creating any other type as a root node
                "valid_children" : [ "drive" ],
                "types" : {
                    // The default type
                    "default" : {
                        // I want this type to have no children (so only leaf nodes)
                        // In my case - those are files
                        "valid_children" : "none",
                        // If we specify an icon for the default type it WILL OVERRIDE the theme icons
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/file.png"
                        }
                    },
                    // The `folder` type
                    "application" : {
                        // can have files and other folders inside of it, but NOT `drive` nodes
                        "valid_children" : [ "role", "permission","default" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/application.png"
                        }
                    },
                    // The `drive` nodes 
                    "role" : {
                        // can have files and folders inside, but NOT other `drive` nodes
                        "valid_children" : [ "permission", "default" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/role.png"
                        }
                    },
                    // The `drive` nodes 
                    "permission" : {
                        // can have files and folders inside, but NOT other `drive` nodes
                        "valid_children" : [ "none" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/check.png"
                        }
                    },
                    // The `folder` type
                    "application_disabled" : {
                        // can have files and other folders inside of it, but NOT `drive` nodes
                        "valid_children" : [ "role", "permission","default" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/application_d.png"
                        }
                    },
                    // The `drive` nodes 
                    "role_disabled" : {
                        // can have files and folders inside, but NOT other `drive` nodes
                        "valid_children" : [ "permission", "default" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/role_d.png"
                        }
                    },
                    // The `drive` nodes 
                    "permission_disabled" : {
                        // can have files and folders inside, but NOT other `drive` nodes
                        "valid_children" : [ "none" ],
                        "icon" : {
                            "image" : "<?php echo $this->webroot;?>img/cross.png"
                        }
                    }                    
                }
            }            
        })
        .bind("loaded.jstree", function (event, data) {
            $.jstree._reference('#tree').open_all();
        })
        .bind("refresh.jstree", function (event, data) {
            $.jstree._reference('#tree').open_all();
        })        
        .bind("select_node.jstree", function(e, data) {
            data.rslt.obj.each(function () {
                //alert($(this).attr("id").replace("node_",""));
                jQuery.jstree._reference('#catree')._get_settings().json_data.ajax.url = "<?php echo $this->webroot . 'acls/pr_controlleractiontreelist_json'; ?>";
                jQuery.jstree._reference('#catree')._get_settings().json_data.ajax.data = 'data[id]='+$(this).attr("id").split("_")[1];
                jQuery.jstree._reference('#catree')._get_settings().json_data.ajax.type = 'POST';
                $('#catree').jstree('refresh',-1);
                //$("#p_res_view").html('resource -> '+$.jstree._reference('#tree').get_path(this).toString().replace(/,/g, '/'));
                //viewPrivilege();
            });
        });        
        //$('button').button();
        $('button[name="Applications.create"]').click(function(){
            $.post(
            '<?php echo $this->webroot . "applications/pr_create"; ?>', 
            $('form[id="Applications"]').serialize(),
            function(data){
                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        //$('#debug').html(data);
                        $('#tree').jstree('refresh',-1);
            },
            'json'
        );
        });
        $('button[name="Applications.delete"]').click(function(){
            var application_id = 0;
            var selected_application = jQuery.jstree._reference('#tree')._get_node (null , false);            
            if(selected_application) {
                if (selected_application.attr('rel')=='application'){
                    application_id = selected_application.attr('id');
                }else{
                    alert('Please select an application to delete. Selected node is not a application.');
                    return;                                        
                }
            }else{
                alert('Please select an application to delete.');
                return;
            }            
            $.post(
            '<?php echo $this->webroot . "applications/prDelete"; ?>', 
            {'data[Applications][id]':application_id},
            function(data){
                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        //$('#debug').html(data);
                        $('#tree').jstree('refresh',-1);
            },
            'json'
        );
        });        
        $('button[name="Roles.create"]').click(function(){
            var application_id = 0;
            var selected_application = jQuery.jstree._reference('#tree')._get_node (null , false);
            if(selected_application) {
                if (selected_application.attr('rel')=='application'){
                    application_id = selected_application.attr('id');
                }else{
                    alert('Please select an Application.');
                    return;                    
                }
            }else{
                alert('Please select an Application.');
                return;
            }
            $.post(
            '<?php echo $this->webroot . "roles/pr_create"; ?>', 
            {'data[Roles][nu_application_id]':application_id,'data[Roles][name]':$('#RolesVcRoleName').val()},
            function(data){
                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        $('#RolesVcRoleName').val('');
                        $('#tree').jstree('refresh',-1);
            },
            'json'
        );
        });
        $('button[name="Roles.delete"]').click(function(){
            var role_id = 0;
            var selected_role = jQuery.jstree._reference('#tree')._get_node (null , false);
            if(selected_role) {
                if (selected_role.attr('rel')=='role'){
                    role_id = selected_role.attr('id');
                }else{
                    alert('Please select a role to delete. Selected node is not a role.');
                    return;                                        
                }
            }else{
                alert('Please select a role to delete.');
                return;
            }
            $.post(
            '<?php echo $this->webroot . "roles/prDelete"; ?>', 
            {'data[Roles][id]':role_id},
            function(data){
                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        //$('#debug').html(data);
                        $('#tree').jstree('refresh',-1);
            },
            'json'
        );
        });        
        $('button[name="PermissionsCreate"]').click(function(){
            var application_id = 0;
            var selected_application = jQuery.jstree._reference('#tree')._get_node (null , false);
            if(selected_application) {
                if (selected_application.attr('rel')=='application'){
                    application_id = selected_application.attr('id');
                }else{
                    alert('Please select an Application.');
                    return;                    
                }
            }else{
                alert('Please select an Application.');
                return;
            }            
            $.post(
            '<?php echo $this->webroot . "permissions/pr_create"; ?>', 
            {'data[Permissions][nu_application_id]':application_id,'data[Permissions][vc_permission_name]':$('#PermissionsVcPermissionName').val()},
            function(data){
                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        $('#PermissionsVcPermissionName').val('');
                        $('#tree').jstree('refresh',-1);
            },
            'json'
        );
        }); 
        $('button[name="PermissionsDelete"]').click(function(){
            var permission_id = 0;
            var selected_permission = jQuery.jstree._reference('#tree')._get_node (null , false);
            if(selected_permission) {
                if (selected_permission.attr('rel')=='permission' || selected_permission.attr('rel')=='permission_disabled'){
                    permission_id = selected_permission.attr('id').split('_')[1];
                }else{
                    alert('Please select a permission to delete. Selected node is not a permission.');
                    return;                                        
                }
            }else{
                alert('Please select a permission to delete.');
                return;
            }
            $.post(
            '<?php echo $this->webroot . "permissions/prDelete"; ?>', 
            {'data[Permissions][id]':permission_id},
            function(data){
                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        //$('#debug').html(data);
                        $('#tree').jstree('refresh',-1);
            },
            'json'
        );
        });        
        $('#PermissionsDisable').click(function(){
            var selectednode = jQuery.jstree._reference('#tree')._get_node (null , false);
            if(selectednode){
                var selectedNodeRel = selectednode.attr('rel');
                if(selectedNodeRel=='permission' || selectedNodeRel=='permission_disabled'){
                    var selectedNodeId = selectednode.attr('id').split("_")[1];
                    var selectedNodeParent = jQuery.jstree._reference('#tree')._get_parent(selectednode);
                    var selectedNodeParentId = selectedNodeParent.attr('id');
                    //alert(selectedNodeParentId+' '+selectedNodeId);
                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">Disabling Permission...</div>');
                    jQuery('#response-message').highlightStyle();
                    jQuery('#response-message').show();                    
                    $.post(
                    '<?php echo $this->webroot . "acls/pr_permissiondisable_json"; ?>', 
                    {'data[RolesPermissions][nu_permission_id]':selectedNodeId,'data[RolesPermissions][nu_role_id]':selectedNodeParentId},
                    function(data){
                        //alert(data.message);
                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        //$('#debug').html(data);
                        //$('#debug').html(data);
                        $('#tree').jstree('refresh',-1);
                    },
                    'json'
                );
                }else{
                    alert('Please select a permission node.') 
                }              
            }else{
                alert('Please select a node.');
            }
        }); 
        $('#PermissionsEnable').click(function(){
            var selectednode = jQuery.jstree._reference('#tree')._get_node (null , false);
            if(selectednode){
                var selectedNodeRel = selectednode.attr('rel');
                if(selectedNodeRel=='permission' || selectedNodeRel=='permission_disabled'){
                    var selectedNodeId = selectednode.attr('id').split("_")[1];
                    var selectedNodeParent = jQuery.jstree._reference('#tree')._get_parent(selectednode);
                    var selectedNodeParentId = selectedNodeParent.attr('id');
                    var selectedNodeApplicationId = jQuery.jstree._reference('#tree')._get_parent(selectedNodeParent).attr('id');
                    //alert(selectedNodeParentId+' '+selectedNodeId);
                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">Enabling Permission...</div>');
                    jQuery('#response-message').highlightStyle();
                    jQuery('#response-message').show();                    
                    $.post(
                    '<?php echo $this->webroot . "acls/pr_permissionenable_json"; ?>', 
                    {'data[Applications][id]':selectedNodeApplicationId,'data[RolesPermissions][nu_permission_id]':selectedNodeId,'data[RolesPermissions][nu_role_id]':selectedNodeParentId},
                    function(data){
                        //alert(data.message);
                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        //$('#debug').html(data);
                        //$('#debug').html(data);
                        $('#tree').jstree('refresh',-1);
                    },
                    'json'
                );
                }else{
                    alert('Please select a permission node.') 
                }              
            }else{
                alert('Please select a node.');
            }
        });
        $('#ControllerActionAllow').click(function(){
            var selectednode = jQuery.jstree._reference('#catree')._get_node (null , false);
            var selectedNodePermission = jQuery.jstree._reference('#tree')._get_node(null , false);
            if(selectednode && selectedNodePermission){
                var selectedNodeRel = selectednode.attr('rel');
                if(selectedNodeRel=='controller_notspecified' || selectedNodeRel=='controller_enabled' || selectedNodeRel=='controller_disabled' || selectedNodeRel=='action_notspecified' || selectedNodeRel=='action_enabled' || selectedNodeRel=='action_disabled'){
                    var selectedNodeId = selectednode.attr('id');
                    var selectedNodeParent = jQuery.jstree._reference('#tree')._get_parent(selectednode);
                    var selectedNodeParentId = selectedNodeParent.attr('id');
                    var selectedNodePermissionId = selectedNodePermission.attr('id').split('_')[1];
                    //alert(selectedNodePermissionId +' '+ selectedNodeParentId+' '+selectedNodeId);
                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">Allowing Controller / Action...</div>');
                    jQuery('#response-message').highlightStyle();
                    jQuery('#response-message').show();                    
                    $.post(
                    '<?php echo $this->webroot . "acls/pr_controlleractionallow_json"; ?>', 
                    {'data[nu_permission_id]':selectedNodePermissionId,'data[controller_alias]':selectedNodeParentId,'data[action_alias]':selectedNodeId},
                    function(data){
                        //alert(data.message);
                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;display:none;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        //$('#debug').html(data);
                        //$('#debug').html(data);
                        $('#catree').jstree('refresh',-1);
                    },
                    'json'
                );
                }else{
                    alert('Please select Controller / Action type node.') 
                }              
            }else{
                alert('Please select both Permission and Controller / Action.');
            }
        });
       $('#ControllerActionDeny').click(function(){
            var selectednode = jQuery.jstree._reference('#catree')._get_node (null , false);
            var selectedNodePermission = jQuery.jstree._reference('#tree')._get_node(null , false);
            if(selectednode && selectedNodePermission){
                var selectedNodeRel = selectednode.attr('rel');
                if(selectedNodeRel=='controller_notspecified' || selectedNodeRel=='controller_enabled' || selectedNodeRel=='controller_disabled' || selectedNodeRel=='action_notspecified' || selectedNodeRel=='action_enabled' || selectedNodeRel=='action_disabled'){
                    var selectedNodeId = selectednode.attr('id');
                    var selectedNodeParent = jQuery.jstree._reference('#tree')._get_parent(selectednode);
                    var selectedNodeParentId = selectedNodeParent.attr('id');
                    var selectedNodePermissionId = selectedNodePermission.attr('id').split('_')[1];
                    //alert(selectedNodePermissionId +' '+ selectedNodeParentId+' '+selectedNodeId);
                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">Denying Controller / Action...</div>');
                    jQuery('#response-message').highlightStyle();
                    jQuery('#response-message').show();                    
                    $.post(
                    '<?php echo $this->webroot . "acls/pr_controlleractiondeny_json"; ?>', 
                    {'data[nu_permission_id]':selectedNodePermissionId,'data[controller_alias]':selectedNodeParentId,'data[action_alias]':selectedNodeId},
                    function(data){
                        //alert(data.message);
                        $('.new-messsages').html('<div style="width:500px;margin:0 auto;display:none;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        //$('#debug').html(data);
                        $('#catree').jstree('refresh',-1);
                    },
                    'json'
                );
                }else{
                    alert('Please select Controller / Action type node.') 
                }              
            }else{
                alert('Please select both Permission and Controller / Action.');
            }
        }); 
       $('#ControllerActionRelease').click(function(){
            var selectednode = jQuery.jstree._reference('#catree')._get_node (null , false);
            var selectedNodePermission = jQuery.jstree._reference('#tree')._get_node(null , false);
            if(selectednode && selectedNodePermission){
                var selectedNodeRel = selectednode.attr('rel');
                if(selectedNodeRel=='controller_notspecified' || selectedNodeRel=='controller_enabled' || selectedNodeRel=='controller_disabled' || selectedNodeRel=='action_notspecified' || selectedNodeRel=='action_enabled' || selectedNodeRel=='action_disabled'){
                    var selectedNodeId = selectednode.attr('id');
                    var selectedNodeParent = jQuery.jstree._reference('#tree')._get_parent(selectednode);
                    var selectedNodeParentId = selectedNodeParent.attr('id');
                    var selectedNodePermissionId = selectedNodePermission.attr('id').split('_')[1];
                    //alert(selectedNodePermissionId +' '+ selectedNodeParentId+' '+selectedNodeId);
                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">Releasing Controller Action...</div>');
                    jQuery('#response-message').highlightStyle();
                    jQuery('#response-message').show();                    
                    $.post(
                    '<?php echo $this->webroot . "acls/pr_controlleractionrelease_json"; ?>', 
                    {'data[nu_permission_id]':selectedNodePermissionId,'data[controller_alias]':selectedNodeParentId,'data[action_alias]':selectedNodeId},
                    function(data){
                        //alert(data.message);
                        $('.new-messsages').html('<div style="width:500px;margin:0 auto;display:none;" id="response-message">'+data.message+'</div>');
                        $('#response-message').highlightStyle();
                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                        //$('#debug').html(data);
                        $('#catree').jstree('refresh',-1);
                    },
                    'json'
                );
                }else{
                    alert('Please select Controller / Action type node.') 
                }              
            }else{
                alert('Please select both Permission and Controller / Action.');
            }
        });        
        
        
        $('input[id="controllersearch"]').keyup(function(){

      var searchText = $(this).val(),
            $allListElements = $('#catree ul > li.jstree-open'),
            $matchingListElements = $allListElements.filter(function(i, el){
                 return $(el).text().indexOf(searchText) !== -1;
            });

        $allListElements.hide();
        $matchingListElements.show();  
    });
    
    $('input[id="viewsearch"]').keyup(function(){

      var searchText = $(this).val(),
            $allListElements = $('#catree ul > li.jstree-open >ul > li'),
            $matchingListElements = $allListElements.filter(function(i, el){
                 return $(el).text().indexOf(searchText) !== -1;
            });

        $allListElements.hide();
        $matchingListElements.show();  
    });
    });
</script>
<div id="debug">

</div>
