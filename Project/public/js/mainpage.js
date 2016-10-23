Ext.require([
    'Ext.form.*',
    'Ext.Img',
    'Ext.tip.QuickTipManager',
    'Ext.layout.container.Absolute'
]);
Ext.onReady(function() {
    Ext.tip.QuickTipManager.init();

    var formPanel = Ext.widget('form', {
        renderTo: Ext.get('content_container'),
        frame: true,
        width: '100%',
        height:'100%',
        title: 'Main Page',
       // bodyPadding: 10,
        bodyBorder: true,

        // defaults: {
        //     anchor: '100%'
        // },
        
        // items: 
        // [

        // ],

         // dockedItems: 
         // [
      
         // ]
    });

});