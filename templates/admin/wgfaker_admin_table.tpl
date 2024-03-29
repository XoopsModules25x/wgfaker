<!-- Header -->
<{include file='db:wgfaker_admin_header.tpl' }>

<{if $formSelect|default:''}>
    <{$formSelect}>
<{/if}>

<{if $table_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_WGFAKER_TABLE_ID}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_TABLE_MOD_DIRNAME}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_TABLE_NAME}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_TABLE_LINES}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_TABLE_DATECREATED}></th>
                <th class="center"><{$smarty.const._AM_WGFAKER_TABLE_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._AM_WGFAKER_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $table_count|default:''}>
        <tbody>
            <{foreach item=table from=$table_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$table.id}></td>
                <td class='center'><{$table.mod_dirname}></td>
                <td class='center'><{$table.name}></td>
                <td class='center'><{$table.lines}></td>
                <td class='center'><{$table.datecreated_text}></td>
                <td class='center'><{$table.submitter_text}></td>
                <td class="center  width5">
                    <a href="field.php?op=list&amp;mid=<{$table.mid}>&amp;tableid=<{$table.id}>" title="<{$smarty.const._AM_WGFAKER_LIST_FIELD}>"><img src="<{$wgfaker_icons_url_16}>fields.png" alt="<{$smarty.const._AM_WGFAKER_LIST_FIELD}> table" ></a>
                    <a href="table.php?op=edit&amp;id=<{$table.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> table" ></a>
                    <a href="table.php?op=delete&amp;id=<{$table.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> table" ></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if !empty($pagenav)}>
        <div class="xo-pagenav floatright"><{$pagenav|default:false}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if !empty($form)}>
    <{$form|default:false}>
<{/if}>
<{if !empty($error)}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgfaker_admin_footer.tpl' }>
