<h1>Transactions</h1>
<p>
    F-engine's database abstraction allows you to use 
    <dfn>
        transactions
    </dfn>
    with databases that support transaction-safe table types.  In MySQL, you'll need
    to be running InnoDB or BDB table types rather than the more common MyISAM.  Most other database platforms support transactions natively.
</p>
<p>
    If you are not familiar with
    transactions we recommend you find a good online resource to learn about them for your particular database.  The information below assumes you
    have a basic understanding of transactions.
</p>
<h2>F-engine's Approach to Transactions</h2>
<p>
    F-engine utilizes an approach to transactions that is very similar to the process used by the popular database class ADODB.  We've chosen that approach
    because it greatly simplifies the process of running transactions.  In most cases all that is required are two lines of code.
</p>
<p>
    Traditionally, transactions have required a fair amount of work to implement since they demand that you to keep track of your queries 
    and determine whether to 
    <dfn>
        commit
    </dfn>
    or 
    <dfn>
        rollback
    </dfn>
    based on the success or failure of your queries. This is particularly cumbersome with
    nested queries. In contrast,
    we've implemented a smart transaction system that does all this for you automatically (you can also manage your transactions manually if you choose to,
    but there's really no benefit).
</p>
<h2>Running Transactions</h2>
<p>
    To run your queries using transactions you will use the 
    <dfn>
        $this->db->trans_start()
    </dfn>
    and 
    <dfn>
        $this->db->trans_complete()
    </dfn>
    functions as follows:
</p>
<code>
    <kbd>
        $this->db->trans_start();
    </kbd>
    <br/>
    $this->db->query('AN SQL QUERY...');
    <br/>
    $this->db->query('ANOTHER QUERY...');
    <br/>
    $this->db->query('AND YET ANOTHER QUERY...');
    <br/>
    <kbd>
        $this->db->trans_complete();
    </kbd>
</code>
<p>
    You can run as many queries as you want between the start/complete functions and they will all be committed or rolled back based on success or failure
    of any given query.
</p>
<h2>Strict Mode</h2>
<p>
    By default F-engine runs all transactions in 
    <dfn>
        Strict Mode
    </dfn>.  When strict mode is enabled, if you are running multiple groups of
    transactions, if one group fails all groups will be rolled back. If strict mode is disabled, each group is treated independently, meaning
    a failure of one group will not affect any others.
</p>
<p>
    Strict Mode can be disabled as follows:
</p>
<code>
    $this->db->trans_strict(FALSE);
</code>
<h2>Managing Errors</h2>
<p>
    If you have error reporting enabled in your 
    <dfn>
        config/database.php
    </dfn>
    file you'll see a standard error message if the commit was unsuccessful. If debugging is turned off, you can
    manage your own errors like this:
</p>
<code>
    $this->db->trans_start();
    <br/>
    $this->db->query('AN SQL QUERY...');
    <br/>
    $this->db->query('ANOTHER QUERY...');
    <br/>
    $this->db->trans_complete();
    <br/>
    <br/>
    if (
    <kbd>
        $this->db->trans_status()
    </kbd>
    === FALSE)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;// generate an error... or use the log_message() function to log your error
    <br/>
    }
</code>
<h2>Enabling Transactions</h2>
<p>
    Transactions are enabled automatically the moment you use 
    <dfn>
        $this->db->trans_start()
    </dfn>.  If you would like to disable transactions you 
    can do so using 
    <dfn>
        $this->db->trans_off()
    </dfn>:
</p>
<code>
    <kbd>
        $this->db->trans_off()
    </kbd>
    <br/>
    <br/>
    $this->db->trans_start();
    <br/>
    $this->db->query('AN SQL QUERY...');
    <br/>
    $this->db->trans_complete();
</code>
<p class="important">
    When transactions are disabled, your queries will be auto-commited, just as they are when running queries without transactions.
</p>
<h2>Test Mode</h2>
<p>
    You can optionally put the transaction system into "test mode", which will cause your queries to be rolled back -- even if the queries produce a valid result. 
    To use test mode simply set the first parameter in the 
    <dfn>
        $this->db->trans_start()
    </dfn>
    function to 
    <samp>
        TRUE
    </samp>:
</p>
<code>
    $this->db->trans_start(
    <samp>
        TRUE
    </samp>); // Query will be rolled back
    <br/>
    $this->db->query('AN SQL QUERY...');
    <br/>
    $this->db->trans_complete();
</code>
<h2>Running Transactions Manually</h2>
<p>
    If you would like to run transactions manually you can do so as follows:
</p>
<code>
    $this->db->trans_begin();
    <br/>
    <br/>
    $this->db->query('AN SQL QUERY...');
    <br/>
    $this->db->query('ANOTHER QUERY...');
    <br/>
    $this->db->query('AND YET ANOTHER QUERY...');
    <br/>
    <br/>
    if ($this->db->trans_status() === FALSE)
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;$this->db->trans_rollback();
    <br/>
    }
    <br/>
    else
    <br/>
    {
    <br/>
    &nbsp;&nbsp;&nbsp;&nbsp;$this->db->trans_commit();
    <br/>
    }
    <br/>
</code>
<p class="important">
    <strong>Note:</strong>
    Make sure to use 
    <kbd>
        $this->db->trans_begin()
    </kbd>
    when running manual transactions, <strong>NOT</strong>
    <dfn>
        $this->db->trans_start()
    </dfn>.
</p>
