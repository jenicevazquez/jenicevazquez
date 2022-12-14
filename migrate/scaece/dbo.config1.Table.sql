/****** Object:  Table [dbo].[config1]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[config1](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[inicia] [date] NOT NULL,
	[vence] [date] NULL,
	[activo] [tinyint] NOT NULL CONSTRAINT [DF_licencias_activo]  DEFAULT ((1)),
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[observaciones] [varchar](100) NULL,
	[capacidad] [bigint] NOT NULL CONSTRAINT [DF_licencias_capacidad]  DEFAULT ((1048576)),
	[paquete] [int] NULL,
	[notificado] [int] NOT NULL CONSTRAINT [DF_licencias_notificado]  DEFAULT ((0)),
	[disco] [varchar](50) NULL CONSTRAINT [DF_licencias_disco]  DEFAULT ('C'),
	[rfc] [varchar](50) NULL,
	[membretado1] [varchar](50) NULL,
	[membretado2] [varchar](50) NULL,
	[usado] [bigint] NOT NULL CONSTRAINT [DF_licencias_usado]  DEFAULT ((0)),
	[operaciones] [bigint] NOT NULL CONSTRAINT [DF_licencias_operaciones]  DEFAULT ((0)),
	[vu] [int] NOT NULL CONSTRAINT [DF_licencias_vu]  DEFAULT ((0)),
	[credenciales] [int] NULL CONSTRAINT [DF_licencias_credenciales]  DEFAULT ((0)),
	[licencia_id] [nchar](10) NULL,
	[tipo] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK__licencia__3213E83FE137714B] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
