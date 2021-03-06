<?php
    //use Yii;
    use yii\helpers\Url;
    use yii\helpers\Html;
    use frontend\assets\ftzmallnew\CartAsset;
    use common\helpers\Tools;
    
    CartAsset::register($this);
    $this -> title = '购物车';
?>

<div class="container cart-container">
    <div class="cart-container-top">
        <p class="timing-clock">请在下单后 <span class="font-color4">30 分钟</span>内完成支付</p>
        <?php
        if ($allItems & is_array($allItems)) {
            foreach ($allItems as $type => $item):?>
            <?= Html::beginForm(['cart/checkout'], 'post', ['id' =>"form-cart",'enctype' => 'multipart/form-data' , 'onsubmit'=>'return canCheckOut(this)']) ?>
            <p class="cart-prompt" storeId=<?= $type ?>></p>
            <div class="customs-bonded-goods goods" storeId=<?= $type ?>>
                <!-- 表头 -->
                <div class="cart-table1-header">
                    <span class="column1">
                        <label class="checkbox-label">
                            <span class="check-bg">
                                <input type="checkbox" class="checkall" autocomplete="off" name="" value=""/>
                            </span>
                        </label>
                    </span>
                    <?php if(isset($storeName[$type])):?>
                    <span class="column2"><?= $storeName[$type]?></span>
                    <?php else:?>
                    <span class="column2"><?= substr($type, 2);?></span>
                    <?php endif;?>
                    
                    <span class="column3">FTZMALL价格（元）</span>
                    <span class="column4">数量</span>
                    <span class="column5">小计（元）</span>
                    <span class="column6">操作</span>
                </div>
                
                <!-- 每一个商品的详情 -->
                <div class="cart-table1">
                <?php foreach ($item as $k => $v):?>
                    
                    <?php if(isset($v['N-start'])) :?>
                    <div class="cartn-con" typeCode=<?= $v['N-metaData']['typecode'] ?> 
                         numOfGoods=<?= $v['N-metaData']['numOfGoods'] ?>  fixedPrice=<?= $v['N-metaData']['fixedPrice'] ?>>
			<div class="vline"></div>
			<div class="cart-tablen-header clearfix">
                            <span class="font-color4 tablen pull-left">N元任选</span>
				<div class="rule pull-left">
                                    <?php if(isset($v['N-status'])) :?>
                                        <span class="nselect-msg">
                                            <?=$v['N-status']['Msg'];?>
                                        </span>
                                    <?php endif;?>
                                    <?php if(isset($v['N-metaData']['landingpage'])) :?>
                                        <a target="_Blank" href="<?=$v['N-metaData']['landingpage'];?>" class="goto">再去看看 ></a>
                                    <?php endif;?>   
                                    
                                </div>
			</div>
                    <?php endif;?>
                    
                    <div <?php if(isset($v['buyable']) && $v['buyable']>0):?> class="cart-table1-con" <?php else:?> class="cart-table1-con product-soldout" <?php endif;?>
                        cartlineId=<?= $v['cartlineId'] ?> itemId=<?= $v['itemId'] ?> 
                        <?php if(isset($v['tariffno'])):?> tariffno=<?=$v['tariffno'] ?> <?php else:?> tariffno="0"<?php endif;?>
                        itemPartNumber=<?= $v['itemPartNumber'] ?> itemOwnerId=<?= $v['itemOwnerId'] ?>  shopId=<?= $v['shopId'] ?> >
                        <span class="column1">
                            <label class="checkbox-label">
                                <span class="check-bg">
                                    <input type="checkbox" class="ftzbox_<?= $type ?>" autocomplete="off" name="productsel[]" value="<?= $v['cartlineId'] ?>"/>
                                </span>
                            </label>
                        </span>
                        <span class="column2">	
                            <?php if(isset($v['children'])):?>
                            <?php foreach($v['children'] as $cid => $cdetail):?>
                            <div class="product-information clearfix">
                                    <?php if(isset($cdetail['parentCatentryId'])):?>
				    <a target="_Blank"  href="<?= Url::to(['product/view','id'=>$cdetail['parentCatentryId']],true) ?>">
                                    <?php else:?>
                                    <a target="_Blank"  href="<?= Url::to(['product/view','id'=>$cid],true) ?>">
                                     <?php endif;?>
                                    <img src="<?=Tools::qnImg(Html::encode($cdetail['itemImageLink']), 72, 72);?>" onerror="javascript:this.src='<?= Url::base()?>/themes/ftzmallnew/src/images/notfound.jpg'" class="product-img">
                                    </a>
                                
				<div class="product-inf">
                                    <?php if(isset($cdetail['parentCatentryId'])):?>
				    <a target="_Blank" class="product-name" href="<?= Url::to(['product/view','id'=>$cdetail['parentCatentryId']],true) ?>">
                                    <?php else:?>
                                    <a target="_Blank" class="product-name" href="<?= Url::to(['product/view','id'=>$cid],true) ?>">
                                     <?php endif;?>
                                    <label class="font-color1">【组合】<label class="font-color7"><?=$cdetail['quantity'];?>件 |</label></label>
                                     <?=$cdetail['itemDisplayText'];?>
                                    </a>
                                    <?php if(isset($cdetail['itemTaxRate'])):?>
                                    <p class="product-rate" data-toogle="popover" data-placement="bottom" data-content="<h4>税费=不含税价格*件数*商品税率</h4>根据海关规定：本商品适用税率为<span class='rate-num'><?= $cdetail['itemTaxRate'] ?></span>，若订单总税额≤50元，海关予以免征。">
                                        适用税率：<span class="rate-num"><?= $cdetail['itemTaxRate'] ?></span><span class="to-span"></span>
                                    </p>
                                    <?php endif;?>
                                    <?php if(isset($v['buyable']) && $v['buyable']<1):?>
                                    <p class="font-color4">商品已下架</p>
                                    <?php endif;?>
                                   
                                </div>
                            </div>
                            <?php endforeach;?> 
                            <?php else:?> 
                            <div  class="product-information clearfix" >
                                <?php if(isset($v['productId'])):?>
                                <a target="_Blank" href="<?= Url::to(['product/view','id'=>$v['productId']],true) ?>">
                                <?php else:?>
                                <a target="_Blank" href="<?= Url::to(['product/view','id'=>$v['itemId']],true) ?>">
                                <?php endif;?>
                                    <img src="<?= Tools::qnImg(Html::encode($v['itemImageLink']), 72, 72);?>" onerror="javascript:this.src='<?= Url::base()?>/themes/ftzmallnew/src/images/notfound.jpg'" class="product-img">
                                </a>
                                <div class="product-inf">
                                <?php if(isset($v['productId'])):?>
                                <a class="product-name" target="_Blank" href="<?= Url::to(['product/view','id'=>$v['productId']],true) ?>">
                                <?php else:?>
                                <a class="product-name" target="_Blank" href="<?= Url::to(['product/view','id'=>$v['itemId']],true) ?>">
                                <?php endif;?>
                                        <label class="font-color1 direct-cut">
                                            <?php if(isset($v['promotionPrice'])):?>【直降】<?php endif;?>
                                        </label>
                                            <?= $v['itemDisplayText'] ?>
                                    </a>
                                    <?php if(in_array($v['itemSalestype'],Yii::$app->params['sm']['store']['isCBT'])):?>
                                    <p class="product-rate" data-toogle="popover" data-placement="bottom" data-content="<h4>税费=不含税价格*件数*商品税率</h4>根据海关规定：本商品适用税率为<span class='rate-num'><?= $v['taxRate'] ?></span>，若订单总税额≤50元，海关予以免征。">
                                        适用税率：<span class="rate-num"><?= $v['taxRate'] ?></span><span class="to-span"></span>
                                    </p>
                                    <?php endif;?> 
                                    <?php if(isset($v['buyable']) && $v['buyable']<1):?>
                                    <p class="font-color4">商品已下架</p>
                                    <?php endif;?>
                                </div>
                            </div>
                            <?php endif;?>
                            
                        </span>
                        <span class="column3">
                            
                            <span class="new-unit-price " ><?= number_format(trim($v['itemOfferPrice']),2,'.','') ?></span>
                            <span class="old-price " op ='<?= number_format(trim($v['itemOfferPrice']),2,'.','') ?>' ></span>
                            
                        </span>
                        <span class="column4 clearfix">
                            <a href="javascript:;" class="quantity-subtract">-</a>
                            <input type="text" name="" class="product-quantity" originalValue ="<?= $v['cartlineQuantity'] ?>" value="<?= $v['cartlineQuantity'] ?>"/>
                            <a href="javascript:;" class="quantity-add">+</a>
                            <?php if(isset($v['maxBuyCount'])):?>
                            <span class="limit-number">限购<?= $v['maxBuyCount'] ?>件</span>
                            <?php endif;?>
                            <?php if(isset($v['minBuyCount'])):?>
                            <span class="limit-number">起订<?= $v['minBuyCount'] ?>件</span>
                            <?php endif;?>
                            
                            <div class="not-enough">库存不足</div>
                            
                        </span>
                        <span class="column5">
                            
                            <span class="new-total-price"><?= number_format($v['itemOfferPrice']*$v['cartlineQuantity'],2,'.','') ?></span>
                            <span class="save-price"></span>
                           
                        </span>
                        <span class="column6">
                            <a href="javascript:;" class="delete-operation"></a>
                        </span>
                    </div>
                    <?php if(isset($v['N-end'])) :?>
                        </div>
                    <?php endif;?>   
                    <?php endforeach;?>
                    <!-- 一个商品详情的结束 -->
            
            <!-- 海关保税结算 -->
            <div class="customsbond-settlement clearfix">
                <div class="pull-left settlement-left">
                    <span class="column1">
                        <label class="checkbox-label">
                            <span class="check-bg">
                                <input type="checkbox" class="checkall" autocomplete="off" name="" value=""/>
                            </span>
                        </label>
                    </span>
                    <span class="column2 for-hover">
                        <a href="javascript:;" class="all-checkbox">全选</a>
                        <a href="<?= Yii::$app->request->referrer?>" class="continue-buy">继续购物　|</a>
                        <a href="javascript:;" class="clear-product">　清空选中商品</a>
                    </span>
                </div>
                <div class="pull-right settlement-right">
                    <div class="order-total">
                        <span class="settlement-column1">商品总计：</span>
                        <span id='original_Price_<?= $type ?>' class="settlement-column2">￥0.00</span>
                    </div>
                    <div class="order-activities">
                        <span class="settlement-column1">活动优惠：</span>
                        <span id='promotion_Price_<?= $type ?>' class="settlement-column2">-￥0.00</span>
                        <span id='order_promotion_tip_<?= $type ?>' class="order-activities-arrow font-color1"></span>
                        <span id='order_promotion_tip_popover_<?= $type ?>' class="activities-popover font-color1" data-toogle="popover" data-placement="top" data-content=""></span>
							
                    </div>
                    <?php if(in_array(Tools::getSalesType($type),Yii::$app->params['sm']['store']['isCBT'])):?>
                    <div class="order-tariffs">
                        <span class="settlement-column1">订单关税：</span>
                        <span id='tax_<?= $type ?>'class="settlement-column2 tariffs-num">￥0.00</span>
                        <span id='tax_no_tip_<?= $type ?>' class="tariffs-notice-arrow">关税≤50，免征！</span>
                        <span id='tax_yes_tip_<?= $type ?>' class="tariffs-notice-arrow1">
                            关税省钱提示：<br/>
                            订单关税超出<span class="font-color4"> 50 </span>元！建议分开下单。（海关免征限额为50元）
                            <p class="font-color4">您可以重新选择商品，把关税总额控制在50元以下，即可免税。</p>
                        </span>
                    </div>
                    <?php endif;?>
                    <div class="order-pay">
                        <span class="settlement-column1">应付金额（不含运费）：</span>
                        <span id='final_Price_<?= $type ?>' class="settlement-column2">￥ 0.00</span>
                    </div>
                    <div class="pay-div clearfix">
                        <input type="submit" disabled="true" class="btn btn-settlement disabled" id="go_to_checkout_<?= $type ?>" value="去结算"></input>
                        <div id='pay_tip_<?= $type ?>' class="pay-notice">海关规定购买多件的总价不能超过￥<?=Yii::$app->params['sm']['store']['maxAmount']?>请您分多次购买。</div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?= Html::endForm() ?>
        <?php endforeach; }?>
        <script>
            var _csrf="<?= Html::encode($_csrf) ?>";
            var updateUrl="<?= Url::to(['cart/update/'],true) ?>";
            var priceUrl="<?= Url::to(['cart/price/'],true) ?>";
            var deleteUrl="<?= Url::to(['cart/delete/'],true) ?>";
            var cancheckOutUrl="<?= Url::to(['cart/can-checkout/'],true) ?>";
            var inventoryUrl = "<?= Url::to(['inventory/check-inventorys/'],true) ?>";
            var shippingRuleUrl="<?= Url::to(['cart/get-shipping-rule/'],true) ?>";
            var nSelectUrl="<?= Url::to(['cart/get-nselect-status/'],true) ?>";
        </script>
    </div>
    <?php /*   此处等后面api ready后再加  deleted by hezonglin 11.04 *?>
    <div class="cart-container-bottom">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#alsobuy" data-toggle="tab">购买的还买了</a>
            </li>
            <li>
                <a href="#todaywel" data-toggle="tab">今日最受欢迎</a>
            </li>
            <li>
                <a href="#recentview" data-toggle="tab">最近查看过</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <ul class="row clearfix tab-pane fade in active" id="alsobuy">
                <li class="final-product pull-left ">
                    <img src="../images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
            </ul>
            <ul class="row clearfix tab-pane fade" id="todaywel">
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
            </ul>
            <ul class="row clearfix tab-pane fade" id="recentview">
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
                <li class="final-product pull-left ">
                    <img src="../src/images/finalpro.png" class="finalpro-img final-img">
                    <p class="final-text pull-left final-m">Teazen江南桑拿柠檬马黛茶可爱卡通茶包9克/蓝色</p>
                    <span class="final-price pull-right final-price">￥28.99</span>
                </li>
            </ul>
        </div>
    </div>
    <?php /***/ ?>
</div>