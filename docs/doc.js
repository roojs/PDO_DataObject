Docs = {
    
    onReady : function()
    {
        Roo.XComponent.hideProgress = true;
        
        Roo.XComponent.build();
        
        baseURL = window.location.pathname.replace(/index\.html$/, '');
    
        
    }
}

Roo.onReady(Docs.onReady);