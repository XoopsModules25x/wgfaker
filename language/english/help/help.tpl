<div id="help-template" class="outer">
    <h1 class="head">Help:
        <a class="ui-corner-all tooltip" href="<{$xoops_url}>/modules/wgfaker/admin/index.php"
           title="Back to the administration of wgFaker"> wgFaker <img src="<{xoAdminIcons home.png}>"
                                                                       alt="Back to the Administration of wgFaker">
        </a></h1>
    <!-- -----Help Content ---------- -->
    <h4 class="odd">Description</h4>
    <p class="even">
        The wgFaker module can be used to modules in XOOPS<br><br>
    </p>
    <h4 class="odd">Install/uninstall</h4>
    <p class="even">
No special measures necessary, follow the standard installation process and extract the wgfaker folder into the ../modules directory. Install the module through Admin -> System Module -> Modules. <br><br>
Detailed instructions on installing modules are available in the <a href="https://goo.gl/adT2i">XOOPS Operations Manual</a>
    </p>
    <h4 class="odd">Features</h4>
    <p class="even">
        The module creates a yaml file with test data. If you copy this files into folder 'modules/{modulename}/testdata/{language}' then you can load the data with ' Import Sample Data'.
    </p>
    <h4 class="odd">Tutorial</h4>
    <p class="even">
        <ul>
            <li>Select the module</li>
            <li>Read tables and fields
                <br><img style="max-width:800px" src="<{$xoops_url}>/modules/wgfaker/language/english/help/1_read_table_fields.png"></li>
            <li>based on field type the module makes a pre-selection of possible datatype (= output type)
                <br><img style="max-width:800px" src="<{$xoops_url}>/modules/wgfaker/language/english/help/3_check_preselect.png"></li>
            <li>change the values for datatype in order to get the data you wish
                <br><img style="max-width:800px" src="<{$xoops_url}>/modules/wgfaker/language/english/help/4_changed_datatype.png"></li>
            <li>Click on 'Generate testdata'. If files were generated successfully two new buttons appearing
                <br><img style="max-width:800px" src="<{$xoops_url}>/modules/wgfaker/language/english/help/5_success.png"></li>
            <li>Check out whether result is proper, e.g. table view
                <br><img style="max-width:800px" src="<{$xoops_url}>/modules/wgfaker/language/english/help/6_result_table.png"></li>
            <li>copy it into 'modules/{modulename}/testdata/{language}' and load them</li>
        </ul>
        Have fun :)
    </p>
    <!-- -----Help Content ---------- -->
</div>