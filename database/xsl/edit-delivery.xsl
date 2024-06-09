<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:param name="payment_id"/>

  <xsl:template match="/">
        <div class="form-group">
            <label for="payment_id">Payment ID</label>
            <input type="text" name="payment_id" class="form-control" id="payment_id" placeholder="ID" value="{$payment_id}" readonly="readonly"/>
        </div>
        <div class="form-group">
            <label for="delivery_date">Delivery Date</label>
            <input type="text" name="delivery_date" class="form-control" id="delivery_date" placeholder="delivery date" value="{delivery/car[payment_id=$payment_id]/delivery_date}" readonly="readonly"/>
        </div>
        <div class="form-group">
            <label class="col-sm-3 col-form-label">Delivery Status</label>
            <div class="col-sm-4">
              <div class="form-check">
                <label class="form-check-label">
                  <xsl:choose>
                    <xsl:when test="delivery/car[payment_id=$payment_id]/delivery_status = 'Prepare to Ship'">
                        <input type="radio" class="form-check-input" name="delivery_status" id="prepareToShip" value="Prepare to Ship " checked="checked"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <input type="radio" class="form-check-input" name="delivery_status" id="prepareToShip" value="Prepare to Ship "/>
                    </xsl:otherwise>
                  </xsl:choose> Prepare to Ship 
                </label>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-check">
                <label class="form-check-label">
                  <xsl:choose>
                    <xsl:when test="delivery/car[payment_id=$payment_id]/delivery_status = 'in Transit'">
                        <input type="radio" class="form-check-input" name="delivery_status" id="inTransit" value="in Transit" checked="checked"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <input type="radio" class="form-check-input" name="delivery_status" id="inTransit" value="in Transit"/>
                    </xsl:otherwise>
                  </xsl:choose> in Transit
                </label>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-check">
                <label class="form-check-label">
                  <xsl:choose>
                    <xsl:when test="delivery/car[payment_id=$payment_id]/delivery_status = 'Delivered'">
                        <input type="radio" class="form-check-input" name="delivery_status" id="delivered" value="Delivered" checked="checked"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <input type="radio" class="form-check-input" name="delivery_status" id="delivered" value="Delivered"/>
                    </xsl:otherwise>
                  </xsl:choose> Delivered
                </label>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-check">
                <label class="form-check-label">
                  <xsl:choose>
                    <xsl:when test="delivery/car[payment_id=$payment_id]/delivery_status = 'Delayed'">
                        <input type="radio" class="form-check-input" name="delivery_status" id="delayed" value="Delayed" checked="checked"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <input type="radio" class="form-check-input" name="delivery_status" id="delayed" value="Delayed"/>
                    </xsl:otherwise>
                  </xsl:choose> Delayed
                </label>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-check">
                <label class="form-check-label">
                  <xsl:choose>
                    <xsl:when test="delivery/car[payment_id=$payment_id]/delivery_status = 'on Hold'">
                        <input type="radio" class="form-check-input" name="delivery_status" id="onHold" value="on Hold" checked="checked"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <input type="radio" class="form-check-input" name="delivery_status" id="onHold" value="on Hold"/>
                    </xsl:otherwise>
                  </xsl:choose> on Hold
                </label>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="form-check">
                <label class="form-check-label">
                  <xsl:choose>
                    <xsl:when test="delivery/car[payment_id=$payment_id]/delivery_status = 'Ready for Pickup'">
                        <input type="radio" class="form-check-input" name="delivery_status" id="readyForPickup" value="Ready for Pickup" checked="checked"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <input type="radio" class="form-check-input" name="delivery_status" id="readyForPickup" value="Ready for Pickup"/>
                    </xsl:otherwise>
                  </xsl:choose> Ready for Pickup
                </label>
              </div>
            </div>
        </div>
        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
        <a href="/admin/delivery" class="btn btn-light">Cancel</a>
  </xsl:template>
</xsl:stylesheet>
