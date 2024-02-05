<?php

require_once 'vendor/autoload.php';

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\PrivateKeyFactory;
use BitWasp\Bitcoin\Key\PrivateKeyInterface;
use BitWasp\Bitcoin\Network\NetworkFactory;

function is_valid_wallet($walletAddress, $privateKeyHex)
{
    try {
        $network = NetworkFactory::bitcoin();
        $privateKey = PrivateKeyFactory::fromHex($privateKeyHex);
        $publicKey = $privateKey->getPublicKey();
        $generatedWalletAddress = $publicKey->getAddress($network)->getAddress();
        return $generatedWalletAddress === $walletAddress;
    } catch (\Exception $e) {
        return false;
    }
}

if ($argc < 3) {
    echo "Usage: php check_wallet.php <wallet_address> <private_key_hex>\n";
    exit(1);
}

$walletAddress = $argv[1];
$privateKeyHex = $argv[2];

if (is_valid_wallet($walletAddress, $privateKeyHex)) {
    echo "The wallet address and private key pair is correct.\n";
} else {
    echo "The wallet address and private key pair is not correct.\n";
}
