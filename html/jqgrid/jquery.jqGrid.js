// we make it simple as possible
function jqGridInclude()
{
    var pathtojsfiles = "/jqgrid/"; // need to be ajusted
    // if you do not want some module to be included
    // set include to false.
    // by default all modules are included.
    var minver = false;
    var modules = [
        { include: true, incfile:'js/grid.base.js',minfile: 'min/grid.base-min.js'}, // jqGrid base
        { include: true, incfile:'js/grid.formedit.js',minfile: 'min/grid.formedit-min.js' }, // jqGrid Form editing
        { include: false, incfile:'js/grid.inlinedit.js',minfile: 'min/grid.inlinedit-min.js' }, // jqGrid inline editing
        { include: false, incfile:'js/grid.subgrid.js',minfile: 'min/grid.subgrid-min.js'}, //jqGrid subgrid
        { include: false, incfile:'js/grid.postext.js',minfile: 'min/grid.postext-min.js'}, //jqGrid post extension
        { include: true, incfile:'js/jqDnR.js',minfile: 'js/jqDnR.js'}
    ];
    for(var i=0;i<modules.length; i++)
    {
        if(modules[i].include == true) {
        	if (minver != true) IncludeJavaScript(pathtojsfiles+modules[i].incfile);
        	else IncludeJavaScript(pathtojsfiles+modules[i].minfile);
        }
    }
    function IncludeJavaScript(jsFile)
    {
      document.write('<script type="text/javascript" src="'
        + jsFile + '"></script>');
    }
}

jqGridInclude();