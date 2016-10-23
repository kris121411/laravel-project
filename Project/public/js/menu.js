Ext.require('Ext.tab.*');

Ext.onReady(function(){

Ext.ns('menu').items ;

    var tabs = Ext.widget('tabpanel', {
        renderTo: Ext.get('content_container'),
       // activeTab: 0,
        width: '100%',
        height: '100%',
        plain: true,
        defaults :{
            autoScroll: true,
            bodyPadding: 10
        },
        listeners:
        {
             render: function() 
             {
               var tab = gettabs();
                tab.load({
                callback: function(){
                    var count = 0;
                        Ext.each(tab.proxy.reader.jsonData, function(tab)
                            {
                                 var set_item;
                                 var items = gettabitems(tab);
                                 items.load({
                                    callback: function()
                                    {
                                        Ext.each(items.proxy.reader.jsonData, function(item)
                                        {
                                           tabs.insert(count,{
                                            title:tab,
                                            html:item
                                        });
                                           tabs.setActiveTab(0);
                                        });
                                        
                                    }
                                 });
                                
                                count++;
                            });
                }
            });
             }
        },
    });

function gettabs(){
var data = new Array();
Ext.define('data_model', {
    extend: 'Ext.data.Model',
    fields:
     [
        {name: 'data'},
    ]
});

var mytabs = Ext.create('Ext.data.Store', {
id:'tab_store',
 model: 'data_model',
 proxy: {
     type: 'ajax',
     url: '/home/get_tab',
     reader: {
         type: 'json',
         root: 'users'
     }
 },
 autoLoad: true
});
return mytabs;
};

function gettabitems(params){
var data = new Array();
Ext.define('data_model', {
    extend: 'Ext.data.Model',
    fields:
     [
        {name: 'data'},
        
    ]
});

var tabitems = Ext.create('Ext.data.Store', {
id:'tab_store',
 model: 'data_model',
 proxy: {
     type: 'ajax',
     url: '/home/get_tabitems',
     reader: {
         type: 'json',
         root: 'users'
     },
     extraParams: {tab:params}
 },
 autoLoad: true
});
return tabitems;
};


});