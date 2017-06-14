<?php
/**
 * 2007-2014 [PagSeguro Internet Ltda.]
 *
 * NOTICE OF LICENSE
 *
 *Licensed under the Apache License, Version 2.0 (the "License");
 *you may not use this file except in compliance with the License.
 *You may obtain a copy of the License at
 *
 *http://www.apache.org/licenses/LICENSE-2.0
 *
 *Unless required by applicable law or agreed to in writing, software
 *distributed under the License is distributed on an "AS IS" BASIS,
 *WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *See the License for the specific language governing permissions and
 *limitations under the License.
 *
 *  @author    PagSeguro Internet Ltda.
 *  @copyright 2007-2014 PagSeguro Internet Ltda.
 *  @license   http://www.apache.org/licenses/LICENSE-2.0
 */

/**
* 
*/

class PagSeguroConfigWrapper
{
    const PAGSEGURO_ENV = "";
    const PAGSEGURO_EMAIL = "";
    const PAGSEGURO_TOKEN_PRODUCTION = "";
    const PAGSEGURO_TOKEN_SANDBOX = "";
    const PAGSEGURO_APP_ID_PRODUCTION = "";
    const PAGSEGURO_APP_ID_SANDBOX = "";
    const PAGSEGURO_APP_KEY_PRODUCTION = "";
    const PAGSEGURO_APP_KEY_SANDBOX = "";
    const PAGSEGURO_CHARSET = "UTF-8";
    const PAGSEGURO_LOG_ACTIVE = false;
    const PAGSEGURO_LOG_LOCATION = "";

    public static function getConfig()
    {
        $PagSeguroConfig = array();

          $pags_status = PFPGIssetControl('pags_status','',0);
          $pags_mode = PFPGIssetControl('pags_mode','',0);
          if ($pags_mode == 1) {
            $PagSeguroConfig['environment'] = "production";
          }else{
            $PagSeguroConfig['environment'] = "sandbox";
          }

          $PagSeguroConfig['credentials'] = array();
          $PagSeguroConfig['credentials']['email'] = PFPGIssetControl('pags_email','','');
          $PagSeguroConfig['credentials']['token']['production'] = PFPGIssetControl('pags_token','','');
          $PagSeguroConfig['credentials']['token']['sandbox'] = PFPGIssetControl('pags_token','','');
          $PagSeguroConfig['credentials']['appId']['production'] = PFPGIssetControl('pags_appid','','');
          $PagSeguroConfig['credentials']['appId']['sandbox'] = PFPGIssetControl('pags_appid','','');
          $PagSeguroConfig['credentials']['appKey']['production'] = PFPGIssetControl('pags_appkey','','');
          $PagSeguroConfig['credentials']['appKey']['sandbox'] = PFPGIssetControl('pags_appkey','','');

          $PagSeguroConfig['application'] = array();
          $PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

          $PagSeguroConfig['log'] = array();
          $PagSeguroConfig['log']['active'] = false;
          $PagSeguroConfig['log']['fileLocation'] = "";

        return $PagSeguroConfig;
    }
}
