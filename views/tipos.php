<?php include("inc/header.php"); ?>

<?php 
    $objTipo = new TiposController();
    $tipos = $objTipo->getTypes();
?>


            <div class="content">
                <h2 class="title">CADASTRO DE TIPOS</h2>
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
                    <form action="tipos/add" name="form-tipos" method="POST">
                        <div class="flex">
                            <input type="hidden" name="id">

                            <div class="input-group w-25">
                                <label>Tipo</label>
                                <input type="text" name="nome" class="input">
                            </div>

                            <div class="input-group w-75">
                                <label>Descrição</label>
                                <input type="text" name="descricao" class="input">
                            </div>
                            
                            <div class="input-group w-25">
                                <label>Alíquota de Imposto (%)</label>
                                <input type="text" name="aliquota" class="input text-center" mascara="currency">
                            </div>

                        </div>
                        <div class="input-group flex justify-end">
                            <button class="btn-default no-marg pointer">Salvar</button>
                        </div>
                    </form>

                    <div class="table">
                        <label>Tipos cadastrados</label>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tipo</th>
                                    <th>Descrição</th>
                                    <th>Alíquota (%)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($tipos as $tipo): ?>
                                    <tr>
                                        <td align="center"><?php echo $tipo['id'] ?></td>
                                        <td><?php echo $tipo['nome'] ?></td>
                                        <td><?php echo $tipo['descricao'] ?></td>
                                        <td align="center"><?php echo formatDecimal($tipo['aliquota']) ?> %</td>
                                        <td class="table-action text-center">
                                            <i class="fas fa-pencil-alt pointer" onclick="editarTipo(<?php echo $tipo['id'] ?>)"></i>
                                            <a href="tipos/delete/?id=<?php echo $tipo['id'] ?>">
                                                <i class="fas fa-trash-alt pointer" onclick="return confirm('Tem certeza que deseja excluir este tipo?')"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>




<?php include("inc/footer.php") ?>