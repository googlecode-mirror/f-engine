<h1>Encryption Class</h1>
<p>
    The Encryption Class provides two-way data encryption.  It uses a scheme that pre-compiles
    the message using a randomly hashed bitwise XOR encoding scheme, which is then encrypted using
    the Mcrypt library.  If Mcrypt is not available on your server the encoded message will
    still provide a reasonable degree of security for encrypted sessions or other such "light" purposes.
    If Mcrypt is available, you'll effectively end up with a double-encrypted message string, which should
    provide a very high degree of security.
</p>
<h2>Setting your Key</h2>
<p>
    A <em>key</em>
    is a piece of information that controls the cryptographic process and permits an encrypted string to be decoded. 
    In fact, the key you chose will provide the <strong>only</strong>
    means to decode data that was encrypted with that key,
    so not only must you choose the key carefully, you must never change it if you intend use it for persistent data.
</p>
<p>
    It goes without saying that you should guard your key carefully.
    Should someone gain access to your key, the data will be easily decoded.  If your server is not totally under your control
    it's impossible to ensure key security so you may want to think carefully before using it for anything
    that requires high security, like storing credit card numbers.
</p>
<p>
    To take maximum advantage of the encryption algorithm, your key should be 32 characters in length (128 bits).
    The key should be as random a string as you can concoct, with numbers and uppercase and lowercase letters. 
    Your key should <strong>not</strong>
    be a simple text string. In order to be cryptographically secure it
    needs to be as random as possible.
</p>
<p>
    Your key can be either stored in your 
    <dfn>
        application/config/config.php
    </dfn>, or you can design your own
    storage mechanism and pass the key dynamically when encoding/decoding.
</p>
<p>
    To save your key to your 
    <dfn>
        application/config/config.php
    </dfn>, open the file and set:
</p>
<code>
    $config['encryption_key'] = "YOUR KEY";
</code>
<h2>Message Length</h2>
<p>
    It's important for you to know that the encoded messages the encryption function generates will be approximately 2.6 times longer than the original
    message.  For example, if you encrypt the string "my super secret data", which is 21 characters in length, you'll end up
    with an encoded string that is roughly 55 characters (we say "roughly" because the encoded string length increments in
    64 bit clusters, so it's not exactly linear).  Keep this information in mind when selecting your data storage mechanism.  Cookies,
    for example, can only hold 4K of information.
</p>
<h2>Initializing the Class</h2>
<p>
    Like most other classes in F-engine, the Encryption class is initialized in your controller using the 
    <dfn>
        $this->load->library
    </dfn>
    function:
</p>
<code>
    $this->load->library('encrypt');
</code>
<p>
    Once loaded, the Encrypt library object will be available using: 
    <dfn>
        $this->encrypt
    </dfn>
</p>
<h2>$this->encrypt->encode()</h2>
<p>
    Performs the data encryption and returns it as a string. Example:
</p>
<code>
    $msg = 'My secret message';
    <br/>
    <br/>
    $encrypted_string = $this->encrypt->encode($msg);
</code>
<p>
    You can optionally pass your encryption key via the second parameter if you don't want to use the one in your config file:
</p>
<code>
    $msg = 'My secret message';
    <br/>
    $key = 'super-secret-key';
    <br/>
    <br/>
    $encrypted_string = $this->encrypt->encode($msg, $key);
</code>
<h2>$this->encrypt->decode()</h2>
<p>
    Decrypts an encoded string.  Example:
</p>
<code>
    $encrypted_string = 'APANtByIGI1BpVXZTJgcsAG8GZl8pdwwa84';
    <br/>
    <br/>
    $plaintext_string = $this->encrypt->decode($encrypted_string);
</code>
<h2>$this->encrypt->set_cipher();</h2>
<p>
    Permits you to set an Mcrypt cipher.  By default it uses 
    <samp>
        MCRYPT_RIJNDAEL_256
    </samp>.  Example:
</p>
<code>
    $this->encrypt->set_cipher(MCRYPT_BLOWFISH);
</code>
<p>
    Please visit php.net for a list of <a href="http://php.net/mcrypt">available ciphers</a>.
</p>
<p>
    If you'd like to manually test whether your server supports Mcrypt you can use:
</p>
<code>
    echo ( ! function_exists('mcrypt_encrypt')) ? 'Nope' : 'Yup';
</code>
<h2>$this->encrypt->set_mode();</h2>
<p>
    Permits you to set an Mcrypt mode.  By default it uses 
    <samp>
        MCRYPT_MODE_ECB
    </samp>.  Example:
</p>
<code>
    $this->encrypt->set_mode(MCRYPT_MODE_CFB);
</code>
<p>
    Please visit php.net for a list of <a href="http://php.net/mcrypt">available modes</a>.
</p>
<h2>$this->encrypt->sha1();</h2>
<p>
    SHA1 encoding function.  Provide a string and it will return a 160 bit one way hash.  Note:  SHA1, just like MD5 is non-decodable. Example:
</p>
<code>
    $hash = $this->encrypt->sha1('Some string');
</code>
<p>
    Many PHP installations have SHA1 support by default so if all you need is to encode a hash it's simpler to use the native
    function:
</p>
<code>
    $hash = sha1('Some string');
</code>
<p>
    If your server does not support SHA1 you can use the provided function.
</p>
