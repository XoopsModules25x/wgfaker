<!-- Header -->
<{include file='db:wgfaker_admin_header.tpl' }>

<h3><{$smarty.const._AM_WGFAKER_DATE_DESC}></h3>

<{if $formSelect|default:''}>
    <{$formSelect}>
<{/if}>

<{if $formDate|default:''}>
    <{$formDate}>
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

<{if !empty($form)}>
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
<{if !empty($error)}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>
<br><br>
<!-- Footer -->
<{include file='db:wgfaker_admin_footer.tpl' }>
