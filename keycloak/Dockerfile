FROM jboss/keycloak

USER root

# Entrypoint
COPY docker-entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Config import script
COPY config-import.sh /opt/config-import.sh
RUN chmod +x /opt/config-import.sh

# Configuration
COPY config $JBOSS_HOME/config
RUN chmod -R +x $JBOSS_HOME/config/*.sh

# Permissions
RUN chgrp -R 0 $JBOSS_HOME && \
    chmod -R g=u $JBOSS_HOME && \
    chmod -R g=u /etc/passwd

USER 1000

EXPOSE 8080

ENTRYPOINT [ "/entrypoint.sh" ]