 <?php include("inc/header.php"); ?>

 <?php 
    $objProduto = new ProdutosController();
    $produtos = $objProduto->getProducts();

    $objTipo = new TiposController();
    $tipos = $objTipo->getTypes();
?>


            <div class="content">
                <h2 class="title">CADASTRO DE PRODUTOS</h2>
                <hr>

                <nav>
                    <a href="/produtos" class="block">
                        <button class="nav-button <?php echo $uriSegments[1] == 'produtos' ? 'active' : '' ?>">Produtos</button>
                    </a>
                    <a href="/tipos" class="block">
                        <button class="nav-button <?php echo $uriSegments[1] == 'tipos' ? 'active' : '' ?>">Tipos</button>
                    </a>
                </nav>

                <div class="card">
                <form action="produtos/add" name="form-produtos" method="POST">
                        <div class="flex">
                            <input type="hidden" name="id">

                            <div class="input-group w-25">
                                <label>Produto</label>
                                <input type="text" name="nome" class="input" required>
                            </div>
                            
                            <div class="input-group w-25">
                                <label>Tipo</label>
                                <select name="id_tipo" class="select" required>
                                    <option>Selecione</option>
                                    <?php foreach($tipos as $tipo): ?>
                                        <option value="<?php echo $tipo['id'] ?>"><?php echo $tipo['nome'] ?></option>
                                    <?php endforeach?>
                                </select>
                            </div>

                            <div class="input-group w-50 flex no-pad">
                                <div class="input-group w-25">
                                    <label>Preço Unitário</label>
                                    <input type="text" name="preco" class="input text-center" required mascara="currency">
                                </div>

                                <div class="input-group w-50">
                                    <label>Descrição</label>
                                    <input type="text" name="descricao" class="input">
                                </div>

                                <div class="input-group w-25">
                                    <label>Estoque</label>
                                    <input type="text" name="estoque" class="input text-center" required>
                                </div>
                            </div>
                        </div>
                        <div class="input-group flex justify-end">
                            <button class="btn-default no-marg pointer">Salvar</button>
                        </div>
                    </form>

                    <div class="table">
                        <label>Produtos cadastrados</label>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item</th>
                                    <th>Tipo</th>
                                    <th>Preço</th>
                                    <th>Descrição</th>
                                    <th>Estoque</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($produtos)): ?>
                                    <?php foreach($produtos as $produto): ?>
                                        <tr>
                                            <td align="center"><?php echo $produto['id'] ?></td>
                                            <td><?php echo $produto['produto'] ?></td>
                                            <td><?php echo $produto['tipo'] ?></td>
                                            <td align="center">R$ <?php echo formatDecimal($produto['preco']) ?></td>
                                            <td><?php echo $produto['descricao'] ?></td>
                                            <td align="right"><?php echo $produto['estoque'] ?></td>
                                            <td class="table-action text-center">
                                                <i class="fas fa-pencil-alt pointer" onclick="editarProduto(<?php echo $produto['id'] ?>)"></i>
                                                <a href="produtos/delete/?id=<?php echo $produto['id'] ?>">
                                                    <i class="fas fa-trash-alt pointer" onclick="return confirm('Tem certeza que deseja excluir este produto?')"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


<?php include("inc/footer.php") ?>
