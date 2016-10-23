
Ext.onReady(function() {
    Ext.tip.QuickTipManager.init();

var model = Ext.define('Users', {
        extend: 'Ext.data.Model',
        fields:['id','firstname','lastname','role','username','password'],
    });

var store = Ext.create('Ext.data.Store', {
    storeId:'userStore',
    model: model,
   proxy: {
     type: 'ajax',
     url: '/user/get_user',
     reader: {
         type: 'json',
         root: 'users'
     }
 },
 autoLoad: true
});

var editor = Ext.create('Ext.grid.plugin.CellEditing', {
            clicksToEdit: 2
        });

Ext.create('Ext.grid.Panel', {
    renderTo: Ext.get('content_container'),
    id:'main_grid',
    title: 'Users',
    frame: true,
    width: '100%',
    height:'100%',
    title: 'List of Users',
    layout: 'fit',
    //bodyBorder: true,
    selType: 'rowmodel',
    plugins: [
        editor
    ],
    store: store,
    listeners: {
    edit: function()
        {
        var records =  Ext.getCmp('main_grid').getStore().getRange();
        var dirty = false;
        for(var i =0; i < records.length; i++)
            {
                var rec = records[i];

                if(rec.dirty == true)
                {
                 dirty = true;
                }
            }
        if(dirty)
        {
                Ext.getCmp('btn_clear').setDisabled(false);
                Ext.getCmp('btn_save').setDisabled(false);
        }
       // else
        // {
            //Ext.getCmp('main_grid').getStore().removeAll();
            //Ext.getCmp('main_grid').getStore().load();
        //         Ext.getCmp('btn_clear').setDisabled(true);
        //         Ext.getCmp('btn_save').setDisabled(true);
        // }
        },
    selectionchange: function(view, records) 
        {
             Ext.getCmp('btn_delete').setDisabled(false);
        }
    },  
    tbar: [
                '->',
            {
                text: 'ADD',
                id:'btn_add',
                width:'8%',
                cls: 'btn',
                 handler: function(){
                    var rec = Ext.create('Users', {
                    id: 0,
                    firstname: "",
                    lastname: "",
                    role: "",
                    username: "",
                    password:""
                    });
                    store.insert(0, rec);
                    editor.startEditByPosition({
                        row: 0, 
                        column: 0
                    });
                    Ext.getCmp('btn_clear').setDisabled(false);
                    Ext.getCmp('btn_save').setDisabled(false);
                },
            },
            {
                text: 'SAVE',
                id:'btn_save',
                 width:'8%',
                 cls: 'btn',
                 disabled: true,
                handler: function(){

                               var gridhasblank = false;
                               var grid = Ext.getCmp('main_grid');
                               if (grid) {
                                  grid.getStore().each(function (record) {
                                     if (   (record.data.firstname == "" || record.data.firstname == null || record.data.firstname == undefined) ||
                                            (record.data.lastname == "" || record.data.lastname == null || record.data.lastname == undefined)  ||
                                            (record.data.role == "" || record.data.role == null || record.data.role == undefined) ||
                                            (record.data.username == "" || record.data.username == null || record.data.username == undefined) ||
                                            (record.data.password == "" || record.data.password == null || record.data.password == undefined)
                                           
                                        ) 
                                        {
                                            gridhasblank = true;
                                        }
                                  });
                               }
                               if(gridhasblank)
                               {
                                 Ext.Msg.show({
                                            title : 'ERROR',
                                            msg   : "Please fill the required field",
                                            icon  : Ext.MessageBox.INFO,
                                             buttons: Ext.Msg.OK,
                                            fn    : function(btn) {
                                            if(btn == 'ok') 
                                            {
                                            }
                                            },
                                                                       
                                            });
                               }
                               else
                               {
                                        var records = grid.getStore().getRange();
                                        var data = new Array();
                                        for(var i =0; i < records.length; i++)
                                        {
                                           var rec = records[i];

                                           if(rec.dirty == true)
                                           {
                                             data.push({
                                                'id':rec.data.id,
                                                'firstname':rec.data.firstname,
                                                'lastname':rec.data.lastname,
                                                'password':rec.data.password,
                                                'username':rec.data.username,
                                                'role':rec.data.role
                                                });
                                            }
                                        }
                                        Ext.Ajax.request({
                                        url : 'user/save_data',
                                        method    : 'GET',
                                        params : {data:  Ext.JSON.encode(data)},
                                        success   : function(response) 
                                        {
                                                    var resp = Ext.JSON.decode(response.responseText);
                                                     if(resp.result == true)
                                                     {
                                                        Ext.Msg.show({
                                                        title : 'INFORMATION',
                                                        msg   : resp.message,
                                                        icon  : Ext.MessageBox.INFO,
                                                        buttons: Ext.Msg.OK,
                                                          fn    : function(btn) {
                                                          if(btn == 'ok') {
                                                           Ext.getCmp('main_grid').getStore().removeAll();
                                                           Ext.getCmp('main_grid').getStore().load();
                                                           Ext.getCmp('btn_clear').setDisabled(true);
                                                           Ext.getCmp('btn_save').setDisabled(true);
                                                           Ext.getCmp('btn_delete').setDisabled(true);
                                                          }
                                                        },
                                                        });
                                                     }
                                                     else
                                                     {
                                                         Ext.Msg.show({
                                                        title : 'Error',
                                                        msg   : resp.message,
                                                        icon  : Ext.MessageBox.ERROR,
                                                        buttons: Ext.Msg.OK,
                                                          fn    : function(btn) {
                                                          if(btn == 'ok') {
                                                            Ext.getCmp('main_grid').getStore().removeAll();
                                                            Ext.getCmp('main_grid').getStore().load();
                                                            Ext.getCmp('btn_clear').setDisabled(true);
                                                            Ext.getCmp('btn_save').setDisabled(true);
                                                            Ext.getCmp('btn_delete').setDisabled(true);
                                                          }
                                                        },
                                                        });
                                                     }         
                                        }
                                           }
                                           );    
                               }
                               
                }
            },
             {
                text: 'CLEAR',
                id:'btn_clear',
                 width:'8%',
                 cls: 'btn',
                 disabled: true,
                handler: function(){
                  Ext.Msg.show({
                            title : 'INFORMATION',
                            msg   : "Are you sure you want to clear the changes?",
                            icon  : Ext.MessageBox.INFO,
                             buttons: Ext.Msg.YESNO,
                            fn    : function(btn) {
                            if(btn == 'yes') 
                            {
                            Ext.getCmp('main_grid').getStore().removeAll();
                            Ext.getCmp('main_grid').getStore().load();
                            Ext.getCmp('btn_clear').setDisabled(true);
                            Ext.getCmp('btn_save').setDisabled(true);
                            Ext.getCmp('btn_delete').setDisabled(true);
                            }
                            },
                                                       
                            });
                },
            },
            {
                text: 'DELETE',
                id:'btn_delete',
                 width:'8%',
                 cls: 'btn',
                 disabled: true
               // handler: this.onAddClick
            }
            ],
    columns: 
    [
        {    text: 'ID',
            dataIndex: 'id',
            hidden: true
        },
        {   text: 'Firstname', 
            dataIndex: 'firstname',
            width:'20%',
            editor: {
                xtype: 'textfield',
               // allowBlank: false
            }
        },
        {   text: 'Lastname', 
            dataIndex: 'lastname', 
            width:'20%',
            editor: {
                xtype: 'textfield',
                //allowBlank: false
            }
        },
        {   text: 'Role',  
            dataIndex: 'role', 
            width:'10%',
            editor: {
                xtype: 'textfield',
               // allowBlank: false
            }
        },
        {   text: 'Username', 
            dataIndex: 'username',
            width:'15%',
            editor: {
                xtype: 'textfield',
               // allowBlank: false
            }

        },
        {   text: 'Password', 
            dataIndex: 'password',
            width:'15%',
            editor: {
                xtype: 'textfield',
               // allowBlank: false
            }
        },
        //  {   text: 'Dep ID', 
        //     dataIndex: 'dep_id',
        //     width:'5%',
        //     editor: {
        //         xtype: 'textfield',
        //        // allowBlank: false
        //     }
        // },
        //  {   text: 'Is Lock', 
        //     dataIndex: 'islock',
        //     width:'5%',
        //     editor: {
        //         xtype: 'textfield',
        //        // allowBlank: false
        //     }
        // }
    ],   
});


});