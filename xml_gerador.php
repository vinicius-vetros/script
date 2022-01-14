<?php 


        //
        $array = array (

            'cliente' => array (
                'nome' => $pedido['nome'],
                'tipoPessoa' => ($pedido['cpf'] ? 'F' : 'J'),
                'endereco' => $pedido['endereco'],
                'cpf_cnpj' => $pedido['nome'],
                'ie' => $pedido['nome'],
                'numero' => $pedido['numero'],
                'complemento' => $pedido['complemento'],
                'bairro' => $pedido['bairro'],
                'cep' => $pedido['cep'],
                'cidade' => $pedido['cidade'],
                'uf' => $pedido['uf'],
                'fone' => ($pedido['celular'] ?: $pedido['telefone']),
                'email' => $pedido['email']
            ),     
            'empdept' => 'account',
            'transporte' => array (
                'transportadora' => $pedido['frete_tipo'],
                'tipo_frete' => $pedido['frete_tipo'],
                'servico_correios' => $pedido['frete_tipo'],
                'dados_etiqueta' => array (
                    'nome' => 'xxxxxxxxxx',
                    'endereco' => $pedido['endereco'],
                    'numero' => $pedido['numero'],
                    'complemento' => $pedido['complemento'],
                    'municipio' => $pedido['municipio'],
                    'uf' => $pedido['uf'],
                    'cep' => $pedido['cep'],
                    'bairro' => $pedido['bairro'],
                ),
            ),

        );

        // xml com 4 niveis
        $xml = new SimpleXMLElement('<pedido/>');

        // 1
        foreach ($array as $n1_campo => $n1_valor) {

            //
            if (!is_array($n1_valor))
                $xml->addChild($n1_campo, $n1_valor);
            else {

                // 2
                $xml_2 = $xml->addChild($n1_campo);

                //
                foreach ($n1_valor as $n2_campo => $n2_valor) {

                    //
                    if (!is_array($n2_valor))
                        $xml_2->addChild($n2_campo, $n2_valor);
                    else {

                        //
                        $xml_3 = $xml_2->addChild($n2_campo);

                        //
                        foreach ($n2_valor as $n3_campo => $n3_valor) {

                            //
                            if (!is_array($n3_valor))
                                $xml_3->addChild($n3_campo, $n3_valor);
                            else {
                                                
                                // 4
                                $xml_4 = $xml_3->addChild($n3_campo);

                                //
                                foreach ($n3_valor as $n4_campo => $n4_valor) {

                                    //
                                    if (!is_array($n4_valor))
                                        $xml_4->addChild($n4_campo, $n4_valor);
                                    else {

                                        //
                                        $xml_5 = $xml_4->addChild($n4_campo);

                                    }

                                }

                            }

                        }

                    }

                }

            }

        }

    
        echo $xml_arquivo = $xml->asXML();
        exit;