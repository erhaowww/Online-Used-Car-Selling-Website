<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:param name="seller_id"/>

<xsl:template match="/">
    <table id="sold" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Mileage</th>
                <th>Color</th>
                <th>Transmission</th>
                <th>Description</th>
                <th>Image</th>
                <th>Price</th>
                <th>Buyer</th>
            </tr>
        </thead>
        <tbody>
            <xsl:for-each select="//seller[seller_id=$seller_id]/car">
                <tr>
                    <td><xsl:value-of select="make"/></td>
                    <td><xsl:value-of select="model"/></td>
                    <td><xsl:value-of select="year"/></td>
                    <td><xsl:value-of select="mileage"/></td>
                    <td><xsl:value-of select="color"/></td>
                    <td><xsl:value-of select="transmission"/></td>
                    <td><xsl:value-of select="description"/></td>
                    <td>
                        <a href="{concat('http://127.0.0.1:8000/user/img/product/', image)}" class="image-link">
                            <img src="{concat('http://127.0.0.1:8000/user/img/product/', image)}" class="img-fluid"/>
                        </a>
                    </td>
                    <td><xsl:value-of select="price"/></td>
                    <td> 
                        <div class="d-flex align-items-center">
                            <div class="">
                                <p class="font-weight-bold mb-0"><xsl:value-of select="buyer/name"/></p>
                                <p class="text-muted mb-0"><xsl:value-of select="buyer/email"/></p>
                            </div>
                        </div>
                    </td>
                </tr>
            </xsl:for-each>
        </tbody>
    </table>
</xsl:template>

</xsl:stylesheet>
