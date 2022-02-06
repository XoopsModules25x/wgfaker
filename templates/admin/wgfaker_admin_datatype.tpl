<!-- Header -->
<{include file='db:wgfaker_admin_header.tpl' }>

<{if $datatype_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_WGFAKER_DATATYPE_ID}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_DATATYPE_NAME}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_DATATYPE_VALUES}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_DATATYPE_WEIGHT}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_DATATYPE_DATECREATED}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_DATATYPE_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._AM_WGFAKER_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $datatype_count|default:''}>
        <tbody>
            <{foreach item=datatype from=$datatype_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$datatype.id}></td>
                <td class='center'><{$datatype.name}></td>
                <td class='center'><{$datatype.values_short}></td>
                <td class='center'><{$datatype.weight}></td>
                <td class='center'><{$datatype.datecreated_text}></td>
                <td class='center'><{$datatype.submitter_text}></td>
                <td class="center  width5">
                    <a href="datatype.php?op=edit&amp;id=<{$datatype.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> datatype" ></a>
                    <a href="datatype.php?op=clone&amp;id_source=<{$datatype.id}>" title="<{$smarty.const._CLONE}>"><img src="<{xoModuleIcons16 editcopy.png}>" alt="<{$smarty.const._CLONE}> datatype" ></a>
                    <a href="datatype.php?op=delete&amp;id=<{$datatype.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> datatype" ></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if $pagenav|default:''}>
        <div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if $form|default:''}>
    <{$form|default:false}>
<{/if}>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgfaker_admin_footer.tpl' }>
