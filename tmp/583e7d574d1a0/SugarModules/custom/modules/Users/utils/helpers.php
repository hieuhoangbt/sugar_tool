<?php

/*
 * AES encryption passwords
 */

function pkcs5_pad($text, $blocksize) {
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
}

function encryptPassword($password) {
    if (!empty($password)) {
        // get Configuration
        $configurator = new Configurator();
        $configurator->loadConfig();

        // get key encryption
        $key = !empty($configurator->config['Casegenix.aes.encryption.secret.key']) ? $configurator->config['Casegenix.aes.encryption.secret.key'] : 'TheBestSecretKey';

        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $input = pkcs5_pad($password, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $encPassword = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encPassword);
    }

    return null;
}

function updateEncryptedPassword($user_id, $encrypted_password, $pad) {
    global $db;
    try {
        $query = "UPDATE users_cstm SET cgx_encrypted_password_c = '$encrypted_password' WHERE id_c = '$user_id'";
        $db->query($query);
    } catch (Exception $e) {
        $GLOBALS['log']->debug("ERROR UPDATE ENCRYPT PASS : " . $e->getMessage());
    }
    global $db;
    try {
        $query = "UPDATE users SET cgx_pad_password_c = '$pad' WHERE id = '$user_id'";
        $db->query($query);
    } catch (Exception $e) {
        $GLOBALS['log']->debug("ERROR UPDATE PAD : " . $e->getMessage());
    }
}
