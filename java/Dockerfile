FROM jboss/wildfly:17.0.0.Final

ENV KEYCLOAK_VERSION 7.0.0

USER 1000
WORKDIR $JBOSS_HOME

RUN curl -s -O https://downloads.jboss.org/keycloak/$KEYCLOAK_VERSION/adapters/keycloak-oidc/keycloak-wildfly-adapter-dist-$KEYCLOAK_VERSION.tar.gz \
    && tar xf keycloak-wildfly-adapter-dist-$KEYCLOAK_VERSION.tar.gz \
    && ./bin/jboss-cli.sh --file=./bin/adapter-elytron-install-offline.cli \
    && rm -rf /opt/jboss/wildfly/standalone/configuration/standalone_xml_history \
    && rm keycloak-wildfly-adapter-dist-$KEYCLOAK_VERSION.tar.gz

ADD dist/cli /opt/jboss/wildfly/cli
RUN ./bin/jboss-cli.sh --file=cli/app-standalone-config.cli \
    && rm -rf /opt/jboss/wildfly/standalone/configuration/standalone_xml_history

USER root
RUN yum -y update && yum -y install dos2unix
COPY src/main/resources/imported/libs/linux/ /usr/local/lib/
RUN dos2unix /usr/local/lib/* && \
    mv /usr/local/lib/* /usr/lib/
COPY src/main/resources/imported/tessdata/ /usr/local/resources/tessdata/
ENV TESSDATA_PREFIX=/usr/local/resources/tessdata/

RUN chgrp -R 0 $JBOSS_HOME && \
    chmod -R g=u $JBOSS_HOME

RUN chmod -R 777 /usr/lib/

USER 1000

ADD build/libs/web-*.war /opt/jboss/wildfly/standalone/deployments/