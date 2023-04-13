<!-- Header -->
<{include file='db:wgfaker_admin_header.tpl' }>

<{if !empty($form)}>
    <{$form|default:false}>
<{/if}>
<{if $result|default:''}>
    <{$result|default:false}>
<{/if}>
<{if !empty($error)}>
    <div class="errorMsg"><strong><{$error|default:false}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgfaker_admin_footer.tpl' }>
