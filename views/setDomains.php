<?php ?>
<h2>Important Notes</h2>
<ul>
<li>Only one admin panel is available, other domains redirect to the master domain admin panel.</li>
<li>The theme for master domain cannot be changed by settings here. </li>
<li>If domain is not added here properly , there can be issues in displaying</li>
<li>If you need to change a domain, you may add it twice and then delete the fauly one, the first occurance of any domain is used </li>

</ul>
<h2>Manage Domains</h2>

<div class="wrap">

    <table class="wp-list-table widefat fixed posts">
        <thead>
            <tr>
                <th><b>Domain</b>  </th>  
                <th>Theme</th>   
                <th>&nbsp;</th>   
            </tr>

        </thead>
        <tbody id="the-list">
            <?php if (is_array($domains) && count($domains) > 0) {
                 
                foreach ($domains as $id=>$domain) { 
                    ?>
                    <tr>
                        <td><?php echo $domain['name'] ?></td>
                        <td><?php echo $domain['theme'] ?></td> 
                        <td> 
                            <form action="" method="POST" >
                                <input type="hidden" name="page" value="armultidomain"/>
                                <input type="hidden" name="id" value="<?php echo $id ?>"/> 
                                <input type="submit" name="submit" value="delete" onclick="confirm('are you sure you want to delete this tree?');"/>
                            </form>

                        </td>
                    </tr>
                    <?php
                }
            }
            ?> 
            <tr>
        <form action="" method="POST" >
            <td><input type="text" name="name" value="" /></td>
            <td><select name="theme">
                    <?php foreach ($themes as $theme=>$tobject) {
                        print_r($theme);
                        ?>
                        <option value="<?php echo $theme ?>"><?php echo $theme ?></option>
                        <?php
                    }
                    ?>  
                </select></td> 
            <td> 


                <input type="submit" name="submit" value="add" />


            </td>
        </form>
        </tr>
        </tbody>
    </table>
</div>
<?php if($htaccess){ ?>
<h2>Issue with variable relative Paths</h2>
<p>If you are using multiple domains with sites hosted on different paths on each domain (eg wp to be accessed at s1.site.com/path1, s2.site.com/path2 etc), the .htaccess file in the root of the wordpress installation needs to be updated as below</p>
<p>Once all your domains are correctly added, After making a backup , set the content of the <b><?php echo $htpath ?></b> file to below </p>
 
<textarea name="" rows="20" cols="120"><?php echo $htaccess ?> 
</textarea>
<div class="wrap">
</div>
<?php }?>