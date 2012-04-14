<?=$html->css('user',null,null);?>
<?=$html->link('back',array('controller'=>'tweets','action'=>'index'));?>
<div style='float:right'>
    <?=$html->link('logout',array('controller'=>'users','action'=>'logout'));?>
</div>
<table>
    <tr>
       <td> <h2>Search for ktwitters</h2></td>
       <td>
        <div id="loadingDiv" style="display: none;">
            &nbsb
            <?php echo $html->image('ajax-loader.gif'); ?> 
        </div> 
       </td>
    </tr>
</table>
<table>
    <tr>
        <td>
            <?php 
                echo $form->create('search');
        	    echo $form->input('criteria',array('class'=>'searchCriteria','label'=>'','type'=>'text','style'=>'float:left'));
            ?>        
        </td>
        <td>
            <?php
                echo $ajax->submit('search',array('update'=>'results',
                     'url'=>'search',
                     'loading'=>"Element.show('loadingDiv')",
                     'loaded'=>"Element.hide('loadingDiv')",
                     'style'=>'float:right'
                     ));
            ?>
        </td>
    </tr>
    <tr>
        <td style="color:black">
            for testing : search for "displayallusers" to get a list of all users
        </td>
    </tr>
</table>

<br />
<div id = 'results'></div>
