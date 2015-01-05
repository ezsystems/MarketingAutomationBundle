<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
        version="1.0"
        xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
        xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"
        xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"
        xmlns:image="http://ez.no/namespaces/ezpublish3/image/"
        exclude-result-prefixes="xhtml custom image">

    <xsl:output method="html" indent="yes" encoding="UTF-8"/>

    <!-- Template below will match the following custom tag: -->
    <!-- <custom name="youtube" custom:video="//www.youtube.com/embed/MfOnq-zXXBw" custom:videoWidth="640" custom:videoHeight="380"/> -->
    <xsl:template match="custom[@name='ezmaform']">
        <div id="MAform">
            <xsl:attribute name="id">
                <xsl:value-of select="concat('MAform-', @custom:form_id)"/>
            </xsl:attribute>
            <script type="text/javascript" src="http://blabla.com/form.js">
                <xsl:attribute name="src">
                    <xsl:value-of select="concat('http://', @custom:hostname, '/', @custom:form_id, '/form.js')"></xsl:value-of>
                </xsl:attribute>
            </script>
        </div>
    </xsl:template>
</xsl:stylesheet>
