Ext.require([
    'Ext.form.*',
    'Ext.Img',
    'Ext.tip.QuickTipManager',
    'Ext.layout.container.Absolute'
]);
Ext.onReady(function() {
    Ext.tip.QuickTipManager.init();

    var formPanel = Ext.widget('form', {
        renderTo: Ext.getBody('content_container'),
        frame: true,
        width: 350,
        bodyPadding: 10,
        bodyBorder: true,
        title: 'Employee Login',
        x: 500,
        
        defaults: {
            anchor: '100%'
        },
        fieldDefaults: {
            labelWidth: 90,
            labelAlign: 'left',
            msgTarget: 'none',
            invalidCls: '' //unset the invalidCls so individual fields do not get styled as invalid
        },

        /*
         * Listen for validity change on the entire form and update the combined error icon
         */
        listeners: {
            fieldvaliditychange: function() {
                this.updateErrorState();
            },
            fielderrorchange: function() {
                this.updateErrorState();
            }
        },

        updateErrorState: function() {
            var me = this,
                errorCmp, fields, errors;

            if (me.hasBeenDirty || me.getForm().isDirty()) { //prevents showing global error when form first loads
                errorCmp = me.down('#formErrorState');
                fields = me.getForm().getFields();
                errors = [];
                fields.each(function(field) {
                    Ext.Array.forEach(field.getErrors(), function(error) {
                        errors.push({name: field.getFieldLabel(), error: error});
                    });
                });
                errorCmp.setErrors(errors);
                me.hasBeenDirty = true;
            }
        },
        items: [{
            xtype: 'textfield',
            name: 'username',
            fieldLabel: 'User Name',
            allowBlank: false,
             listeners: {
              specialkey: function(f,e){
                if (e.getKey() == e.ENTER) 
                {
                  var form = this.up('form').getForm();
                    if (form.isValid()) {
                        Ext.Ajax.request({
                                        url : 'login/authenticate',
                                        method    : 'GET',
                                        params : {data: Ext.JSON.encode(form.getValues())},
                                        success   : function(response) 
                                        {
                                                       var resp = Ext.JSON.decode(response.responseText);
                                                     if(resp.result == true)
                                                     {
                                                        location.href = "http://localhost:8000/home";
                                                     }
                                                     else
                                                     {
                                                         Ext.Msg.show({
                                                        title : 'Error',
                                                        msg   : resp.message,
                                                        icon  : Ext.MessageBox.ERROR,
                                                        buttons: Ext.Msg.OK,
                                                        // fn    : function(btn) {
                                                        //   if(btn == 'ok') {
                                                        //     store.load();
                                                        //     win.close();
                                                        //   }
                                                        // },
                                                       
                                                        });
                                                     }         
                                        }
                                           }
                                           );
                    }
                }
              }
            }
            //fieldStyle: { background: '#ffffff url(./images/logo.jpg) no-repeat left center', paddingLeft: '20px' }
            //emptyText: 'Username'
           // minLength: 6
         }, 
        {
            xtype: 'textfield',
            name: 'password',
            fieldLabel: 'Password',
            inputType: 'password',
            style: 'margin-top:15px',
            allowBlank: false,
             listeners: {
              specialkey: function(f,e){
                if (e.getKey() == e.ENTER) 
                {
                  var form = this.up('form').getForm();
                    if (form.isValid()) {
                        Ext.Ajax.request({
                                        url : 'login/authenticate',
                                        method    : 'GET',
                                        params : {data: Ext.JSON.encode(form.getValues())},
                                        success   : function(response) 
                                        {
                                                       var resp = Ext.JSON.decode(response.responseText);
                                                     if(resp.result == true)
                                                     {
                                                        location.href = "http://localhost:8000/home";
                                                     }
                                                     else
                                                     {
                                                         Ext.Msg.show({
                                                        title : 'Error',
                                                        msg   : resp.message,
                                                        icon  : Ext.MessageBox.ERROR,
                                                        buttons: Ext.Msg.OK,
                                                        // fn    : function(btn) {
                                                        //   if(btn == 'ok') {
                                                        //     store.load();
                                                        //     win.close();
                                                        //   }
                                                        // },
                                                       
                                                        });
                                                     }         
                                        }
                                           }
                                           );
                    }
                }
              }
            }
           // emptyText: 'Password'
           // minLength: 8
        }, 
       
        ],

        dockedItems: [{
            cls: Ext.baseCSSPrefix + 'dd-drop-ok',
            xtype: 'container',
            dock: 'bottom',
            layout: {
                type: 'hbox',
                align: 'middle'
            },
            padding: '10 10 5',
            items: [{
                xtype: 'component',
                id: 'formErrorState',
                baseCls: 'form-error-state',
                flex: 1,
                validText: 'Form is valid',
                invalidText: 'Fill the form',
                tipTpl: Ext.create('Ext.XTemplate', '<ul class="' + Ext.plainListCls + '"><tpl for="."><li><span class="field-name">{name}</span>: <span class="error">{error}</span></li></tpl></ul>'),

                getTip: function() {
                    var tip = this.tip;
                    if (!tip) {
                        tip = this.tip = Ext.widget('tooltip', {
                            target: this.el,
                            title: 'Error Details:',
                            minWidth: 200,
                            autoHide: false,
                            anchor: 'top',
                            mouseOffset: [-11, -2],
                            closable: true,
                            constrainPosition: false,
                            cls: 'errors-tip'
                        });
                        tip.show();
                    }
                    return tip;
                },

                setErrors: function(errors) {
                    var me = this,
                        tip = me.getTip();

                    errors = Ext.Array.from(errors);

                    // Update CSS class and tooltip content
                    if (errors.length) {
                        me.addCls(me.invalidCls);
                        me.removeCls(me.validCls);
                        me.update(me.invalidText);
                        tip.setDisabled(false);
                        tip.update(me.tipTpl.apply(errors));
                    } else {
                        me.addCls(me.validCls);
                        me.removeCls(me.invalidCls);
                        me.update(me.validText);
                        tip.setDisabled(true);
                        tip.hide();
                    }
                }
            }, {
                xtype: 'button',
                formBind: true,
                disabled: true,
                text: 'Login',
                width: 140,
                handler: function(button,event) {
                    var form = this.up('form').getForm();
                    if (form.isValid()) {
                        Ext.Ajax.request({
                                        url : 'login/authenticate',
                                        method    : 'GET',
                                        params : {data: Ext.JSON.encode(form.getValues())},
                                        success   : function(response) 
                                        {
                                                       var resp = Ext.JSON.decode(response.responseText);
                                                     if(resp.result == true)
                                                     {
                                                        location.href = "http://localhost:8000/home";
                                                     }
                                                     else
                                                     {
                                                         Ext.Msg.show({
                                                        title : 'Error',
                                                        msg   : resp.message,
                                                        icon  : Ext.MessageBox.ERROR,
                                                        buttons: Ext.Msg.OK,
                                                        // fn    : function(btn) {
                                                        //   if(btn == 'ok') {
                                                        //     store.load();
                                                        //     win.close();
                                                        //   }
                                                        // },
                                                       
                                                        });
                                                     }         
                                        }
                                           }
                                           );
                    }

                },
            }]
        }]
    });

});