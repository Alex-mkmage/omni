<?php if($this->getItems()->getSize()): ?>
<div class="block block-related">
    <div class="block-title">
        <strong><span><?php echo $this->__('Related Accessories') ?></span></strong>
    </div>
    <ol class="mini-products-list" id="block-related">
    <?php $counter = 0; foreach($this->getItems() as $_item): ++$counter; $_product = Mage::getModel('catalog/product')->load($_item->getId()); ?>
        <li class="item">
            <div class="product">
                <a href="<?php echo $_item->getProductUrl() ?>" title="<?php echo $this->htmlEscape($_item->getName()) ?>" class="product-image"><img src="<?php echo $this->helper('catalog/image')->init($_item, 'thumbnail')->resize(71,71) ?>" width="71" height="71" alt="<?php echo $this->htmlEscape($_item->getName()) ?>" /></a>
                <div class="product-details">
                    <p class="product-name"><a href="<?php echo $_item->getProductUrl() ?>"><?php echo $this->htmlEscape($_item->getName()) ?></a></p>
                    <?php if($_product->isSaleable()): ?>
                        <form action="<?php echo Mage::helper('checkout/cart')->getAddUrl($_product); ?>"  method="post" id="product_addtocart_form_<?php echo $_product->getId(); ?>"<?php if($_product->getOptions()): ?> enctype="multipart/form-data"<?php endif; ?>>
                            <div class="no-display">
                                <input type="hidden" name="product" value="<?php echo $_product->getId() ?>" />
                                <input type="hidden" name="related_product" id="related-products-field<?php echo $_product->getId(); ?>" value="" />
                            </div>
                            <input type="submit" class="no-display" value="Sub"/>
                            <div class="add-to-cart">
                                <div>
                                      <input type="text" name="qty" id="qty<?php echo $_product->getId(); ?>" maxlength="12" value="1" title="<?php echo $this->__('Qty') ?>" class="text qty" />
                                       <span>Quantity</span>
                                </div>
                                
                                <button class="button btn-cart" title="Plaats in winkelwagen" onclick="product_addtocart_form_<?php echo $_product->getId() ?>.submit()" type="button"><span><span><?php echo $this->__('Add to Cart') ?></span></span></button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </li>
    <?php if($counter == 3){ break; } endforeach ?>
    </ol>
    <script type="text/javascript">decorateList('block-related', 'none-recursive')</script>
</div>
<?php endif ?>