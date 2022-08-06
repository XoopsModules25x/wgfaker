<!-- Header -->
<{include file='db:wgfaker_admin_header.tpl' }>

<{if $formSelect|default:''}>
    <{$formSelect}>
<{/if}>

<{if $table_list|default:''}>
    <{foreach item=table from=$table_list}>
        <h3 class="head center" style="border-top:1px solid #ccc;margin-top:20px;padding:10px;"><{$table.name}></h3>
        <{if $table.field_list|default:''}>
            <table class='table table-bordered'>
                <thead>
                <tr class='head'>
                    <th class="center"><{$smarty.const._AM_WGFAKER_FIELD_ID}></th>
                    <th class="center"><{$smarty.const._AM_WGFAKER_FIELD_TABLEID}></th>
                    <th class="center"><{$smarty.const._AM_WGFAKER_FIELD_NAME}></th>
                    <th class="center"><{$smarty.const._AM_WGFAKER_FIELD_TYPE}></th>
                    <th class="center"><{$smarty.const._AM_WGFAKER_FIELD_DATATYPEID}></th>
                    <th class="center"><{$smarty.const._AM_WGFAKER_FIELD_PARAMS}></th>
                    <th class="center"><{$smarty.const._AM_WGFAKER_FIELD_DATECREATED}></th>
                    <th class="center"><{$smarty.const._AM_WGFAKER_FIELD_SUBMITTER}></th>
                    <th class="center width5"><{$smarty.const._AM_WGFAKER_FORM_ACTION}></th>
                </tr>
                </thead>
                <{if $field_count|default:''}>
                <tbody>
                <{foreach item=field from=$table.field_list}>
                    <tr class='<{cycle values='odd, even'}>'>
                        <td class='center'><{$field.id}></td>
                        <td class='center'><{$field.tablename}></td>
                        <td class='center'><{$field.name}></td>
                        <td class='center'><{$field.type}></td>
                        <td class='center'><{$field.datatype_text}></td>
                        <td class='center'><{$field.params}></td>
                        <td class='center'><{$field.datecreated}></td>
                        <td class='center'><{$field.submitter}></td>
                        <td class="center  width5">
                            <a href="field.php?op=edit&amp;id=<{$field.id}>&amp;mid=<{$table.mid}>&amp;tableid=<{$table.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> field" ></a>
                            <a href="field.php?op=delete&amp;id=<{$field.id}>&amp;mid=<{$table.mid}>&amp;tableid=<{$table.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> field" ></a>
                        </td>
                    </tr>
                    <{/foreach}>
                </tbody>
                <{/if}>
            </table>
        <{/if}>
        <div class="center">
            <a class="btn btn-primary" href="field.php?op=reread&amp;mid=<{$table.mid}>&amp;tableid=<{$table.id}>" title="<{$smarty.const._AM_WGFAKER_READ_FIELDS}>"><{$smarty.const._AM_WGFAKER_READ_FIELDS}></a>
            <a class="btn btn-primary" href="field.php?op=generate&amp;mid=<{$table.mid}>&amp;tableid=<{$table.id}>" title="<{$smarty.const._AM_WGFAKER_TESTDATA_GENERATE}>"><{$smarty.const._AM_WGFAKER_TESTDATA_GENERATE}></a>
            <{if $table.yml_exist|default:false}>
                <a target="_blank" class="btn btn-primary" href="field.php?op=show_table&amp;mid=<{$table.mid}>&amp;tableid=<{$table.id}>" title="<{$smarty.const._AM_WGFAKER_TESTDATA_SHOW_TMP}>"><{$smarty.const._AM_WGFAKER_TESTDATA_SHOW_TMP}></a>
                <a target="_blank" class="btn btn-primary" href="field.php?op=show_yml&amp;mid=<{$table.mid}>&amp;tableid=<{$table.id}>" title="<{$smarty.const._AM_WGFAKER_TESTDATA_SHOW_YML}>"><{$smarty.const._AM_WGFAKER_TESTDATA_SHOW_YML}></a>
                <a target="_self" class="btn btn-primary" href="field.php?op=copy_yml&amp;mid=<{$table.mid}>&amp;tableid=<{$table.id}>" title="<{$smarty.const._AM_WGFAKER_TESTDATA_COPY_YML}>"><{$smarty.const._AM_WGFAKER_TESTDATA_COPY_YML}></a>
            <{/if}>
        </div>
    <{/foreach}>
<{/if}>

<{if $table_yaml|default:''}>
    <h3 class="head center" style="border-top:1px solid #ccc;margin-top:20px;padding:10px;"><{$table_yaml.name}></h3>
    <table class='table table-bordered'>
        <thead>
        <tr class='head'>
            <{foreach item=column from=$table_yaml.columns}>
                <th class="center"><{$column}></th>
            <{/foreach}>
        </tr>
        </thead>
        <tbody>
            <{foreach item=lines from=$table_yaml.values}>
                <tr class='<{cycle values='odd, even'}>'>
                    <{foreach item=line from=$lines}>
                    <td class="center"><{$line}></td>
                    <{/foreach}>
                </tr>
            <{/foreach}>
        </tbody>
    </table>
<{/if}>

<{if $form|default:''}>
    <{$form|default:false}>
    <script>
        function toogleFieldParams() {

            var select = document.getElementById('datatypeid');
            var vselected = select.options[select.selectedIndex].value;

            disableEle('param_text');
            disableEle('param_text_running');
            disableEle('param_text_running_blank1');
            disableEle('param_intrangefrom');
            disableEle('param_intrangeto');
            disableEle('param_daterangefrom');
            disableEle('param_daterangeto');
            disableEle('param_table_id');
            disableEle('param_custom_list');

            switch(parseInt(vselected)) {
                case <{$constFixedText}>:
                case <{$constFixedNumber}>:
                    enableEle('param_text');
                    break;
                case <{$constTextRunning}>:
                    enableEle('param_text_running');
                    enableEle('param_text_running_blank1');
                    break;
                case <{$constIntRange}>:
                    enableEle('param_intrangefrom');
                    enableEle('param_intrangeto');
                    break;
                case <{$constDateRange}>:
                    enableEle('param_daterangefrom');
                    enableEle('param_daterangeto');
                    break;
                case <{$constTableId}>:
                    enableEle('param_table_id');
                    break;
                case <{$constCustomList}>:
                    enableEle('param_custom_list');
                    break;
                default:
                    break;
            }
        }

        function enableEle ($ele) {
            xoopsGetElementById($ele).removeAttribute("disabled");
            xoopsGetElementById($ele).style.backgroundColor = "";
        }

        function disableEle ($ele) {
            xoopsGetElementById($ele).setAttribute("disabled", "disabled");
            xoopsGetElementById($ele).style.backgroundColor = "#d4d5d6";
        }

    </script>
<{/if}>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>
<br><br>
<!-- Footer -->
<{include file='db:wgfaker_admin_footer.tpl' }>
